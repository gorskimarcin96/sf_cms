<?php

namespace App\Tools\File\Connector;

interface ConnectorInterface
{
    public function read(string $path): string;

    public function save(string $path, string $contents): void;

    public function delete(string $path): void;
}
