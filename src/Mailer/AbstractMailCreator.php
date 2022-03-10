<?php

namespace App\Mailer;

use App\File\FileManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Twig\Environment;

class AbstractMailCreator
{
    public function __construct(protected MailBuilder $mailBuilder, protected TemplatedEmail $templatedEmail, private FileManager $fileManager, private Environment $twig)
    {
    }

    protected function setLayout($layout): void
    {
        $this->mailBuilder->setLayout($layout);
    }

    protected function append(string $twig, array $variables = [], array $fileNames = []): void
    {
        foreach ($fileNames as $fileName) {
            $this->templatedEmail->embed($this->fileManager->openFile($fileName, true), $fileName);
        }

        $this->mailBuilder->append($this->twig->createTemplate($twig)->render($variables));
    }

    protected function clearElements(): void
    {
        $this->mailBuilder->clearElements();
    }
}
