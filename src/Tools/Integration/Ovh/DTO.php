<?php

namespace App\Tools\Integration\Ovh;

use App\Tools\Integration\Ovh\Model\Service;
use DateTime;

class DTO
{
    public function transform(array $data): Service
    {
        return new Service(
            $data['id'],
            $data['resource']['name'],
            $data['resource']['displayName'],
            new DateTime($data['creationDate']),
            new DateTime($data['expirationDate']),
            new DateTime($data['nextBillingDate']),
        );
    }
}
