<?php

namespace App\Tools\Integration\Ovh;

use App\Tools\Integration\Ovh\Model\Service;
use Ovh\Api;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class Client
{
    public function __construct(private Api $api, private DTO $DTO)
    {
    }

    /** @return Service[] */
    public function getServices(): array
    {
        return (new FilesystemAdapter())->get('servicess', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            foreach ($this->api->get('/service') as $service) {
                $data = $this->api->get('/service/' . $service);
                $data['id'] = $service;

                $services[]= $this->DTO->transform($data);
            }

            return $services ?? [];
        });
    }
}
