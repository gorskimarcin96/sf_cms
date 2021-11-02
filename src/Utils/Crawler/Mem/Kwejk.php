<?php

namespace App\Utils\Crawler\Mem;

use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class Kwejk extends AbstractMem
{
    public function getLinkToRandMem(): string
    {
        try {
            $response = $this->client->request('GET', 'http://kwejk.pl/losowy');
            $crawler = new Crawler($response->getContent(false));

            return $crawler->filter('div.figure-holder>figure.figure>img.full-image')->attr('src');
        } catch (InvalidArgumentException $invalidArgumentException) {
            return $this->getLinkToRandMem();
        }
    }
}
