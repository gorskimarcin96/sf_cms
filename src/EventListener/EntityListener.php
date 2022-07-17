<?php

namespace App\EventListener;

use App\Entity\ConnectorInterface;
use App\Entity\Password;
use App\Entity\Task;
use App\Security\EncryptionManager;
use App\Tools\File\Connector\Traits\ConnectorTrait;
use Doctrine\ORM\Event\LifecycleEventArgs;

class EntityListener
{
    use ConnectorTrait;

    public function __construct(private EncryptionManager $encryptionManager, private iterable $connectorServices)
    {
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof Task) {
            $entity->setEncryptionManager($this->encryptionManager);
        }

        if ($entity instanceof Password) {
            $entity->setPassword($this->encryptionManager->encrypt($entity->getPassword()));
        }

        if ($entity instanceof ConnectorInterface) {
            $connector = $this->getConnectorService($entity::getConnector());

            $entity->setBase64(base64_encode($connector->read($entity->getConnectorPath())));
        }
    }
}
