<?php

namespace App\Crawler\Mem;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractMem
{
    public function __construct(protected HttpClientInterface $client)
    {
    }

    abstract public function getLinkToRandMem(): string;
}
