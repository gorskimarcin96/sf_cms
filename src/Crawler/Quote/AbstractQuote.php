<?php

namespace App\Crawler\Quote;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractQuote
{
    public function __construct(protected HttpClientInterface $client)
    {
    }

    abstract public function getRandQuote(): string;
}
