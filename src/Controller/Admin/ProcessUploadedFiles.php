<?php

namespace App\Controller\Admin;

use App\Tools\File\Connector\Traits\ConnectorTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\Model\FileUploadState;
use Symfony\Component\Form\FormInterface;
use function Symfony\Component\String\u;

trait ProcessUploadedFiles
{
    use ConnectorTrait;

    protected function processUploadedFiles(FormInterface $form): void
    {
        /** @var FormInterface $child */
        foreach ($form as $child) {
            $config = $child->getConfig();

            if (!$config->getType()->getInnerType() instanceof FileUploadType) {
                if ($config->getCompound()) {
                    $this->processUploadedFiles($child);
                }

                continue;
            }

            /** @var FileUploadState $state */
            $state = $config->getAttribute('state');

            if (!$state->isModified()) {
                continue;
            }

            if (null !== $connector = $child->getConfig()->getAttribute('ea_field')->getCustomOption('connector')) {
                $connectorService = $this->getConnectorService($connector);

                if (
                    $state->hasCurrentFiles()
                    && ($state->isDelete() || (!$state->isAddAllowed() && $state->hasUploadedFiles()))
                ) {
                    foreach ($state->getCurrentFiles() as $file) {
                        $connectorService->delete($file);
                    }
                    $state->setCurrentFiles([]);
                }

                $filePaths = (array)$child->getData();
                $downloadDir = $config->getOption('download_path');
                $uploadDir = $config->getOption('upload_dir');

                foreach ($state->getUploadedFiles() as $index => $file) {
                    $fileName = u($filePaths[$index])->replace($uploadDir, '')->toString();
                    $connectorService->save($downloadDir.$fileName, $file->getContent());
                }
            } else {
                $uploadDelete = $config->getOption('upload_delete');

                if (
                    $state->hasCurrentFiles()
                    && ($state->isDelete() || (!$state->isAddAllowed() && $state->hasUploadedFiles()))
                ) {
                    foreach ($state->getCurrentFiles() as $file) {
                        $uploadDelete($file);
                    }
                    $state->setCurrentFiles([]);
                }

                $filePaths = (array)$child->getData();
                $uploadDir = $config->getOption('upload_dir');
                $uploadNew = $config->getOption('upload_new');

                foreach ($state->getUploadedFiles() as $index => $file) {
                    $fileName = u($filePaths[$index])->replace($uploadDir, '')->toString();
                    $uploadNew($file, $uploadDir, $fileName);
                }
            }
        }
    }
}
