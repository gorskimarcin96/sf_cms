<?php

namespace App\Ovh;

use App\Ovh\Model\Service;
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