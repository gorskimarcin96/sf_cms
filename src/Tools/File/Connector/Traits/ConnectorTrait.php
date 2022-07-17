<?php

namespace App\Tools\File\Connector\Traits;

use App\Tools\File\Connector\ConnectorInterface;
use Exception;

trait ConnectorTrait
{
    private iterable $connectorServices;

    /** @throws Exception */
    public function getConnectorService(string $connectorName): ConnectorInterface
    {
        foreach ($this->connectorServices as $connectorService) {
            if ($connectorService::class === $connectorName) {
                return $connectorService;
            }
        }

        throw new Exception();
    }
}
