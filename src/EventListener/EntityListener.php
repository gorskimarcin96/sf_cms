<?php

namespace App\EventListener;

use App\Entity\Task;
use App\Security\EncryptionManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

class EntityListener
{
    public function __construct(private EncryptionManager $encryptionManager)
    {
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Task) {
            $entity->setEncryptionManager($this->encryptionManager);
        }
    }
}
