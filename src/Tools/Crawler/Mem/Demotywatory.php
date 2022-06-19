<?php

namespace App\Tools\Crawler\Mem;

use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class Demotywatory extends AbstractMem
{
    public function getLinkToRandMem(): string
    {
        try {
            $response = $this->client->request('GET', 'https://demotywatory.pl/losuj');
            $crawler = new Crawler($response->getContent(false));

            return $crawler->filter('img.demot')->attr('src');
        } catch (InvalidArgumentException $invalidArgumentException) {
            return $this->getLinkToRandMem();
        }
    }
}
