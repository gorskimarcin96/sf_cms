<?php

namespace App\Tools\Integration\Ovh;

use App\Tools\Integration\IntegrationInterface;
use App\Tools\Integration\Ovh\Model\Service;
use Exception;
use Ovh\Api;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class Client implements IntegrationInterface
{
    public function __construct(private Api $api, private DTO $DTO)
    {
    }

    /** @return Service[] */
    public function getServices(): array
    {
        return (new FilesystemAdapter())->get('services', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            foreach ($this->api->get('/service') as $service) {
                $data = $this->api->get('/service/'.$service);
                $data['id'] = $service;

                $services[] = $this->DTO->transform($data);
            }

            return $services ?? [];
        });
    }

    public function getName(): string
    {
        return 'OVH';
    }

    public function isActive(): bool
    {
        return (new FilesystemAdapter())->get('integration_ovh_is_active', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            try {
                $this->api->get('/service');

                return true;
            } catch (Exception $exception) {
                return false;
            }
        });
    }
}
