<?php

namespace App\Entity;

interface ConnectorInterface
{
    public static function getConnector(): string;

    public function getConnectorPath(): string;

    public function setBase64(string $file): void;

    public function getBase64(): string;
}
