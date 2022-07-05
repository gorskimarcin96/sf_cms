<?php

namespace App\Tools\Crawler\Camasutra;

interface CamasutraInterface
{
    public function getAll(): iterable;

    public function countUrls(): int;

    public function isCountable(): bool;
}
