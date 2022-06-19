<?php

namespace App\Tools\Crawler\Quote;

use Symfony\Component\DomCrawler\Crawler;

class CytatyInfo extends AbstractQuote
{
    public function getRandQuote(): string
    {
        $response = $this->client->request('GET', 'https://www.cytaty.info/losowy/cytat.htm');
        $crawler = new Crawler($response->getContent(false));

        return $crawler->filter('a.text-gray-700')->text() . ' ~ <b>' .
            $crawler->filter('p.text-lg.text-center > a')->text() . '</b>';
    }
}
