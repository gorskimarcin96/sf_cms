<?php

namespace App\Tools\Integration;

interface IntegrationInterface
{
    public function getName(): string;

    public function isActive(): bool;
}
