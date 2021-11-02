<?php

namespace App\Utils\Crawler\Quote;

use Symfony\Component\DomCrawler\Crawler;

class Biblijni extends AbstractQuote
{
    public function getRandQuote(): string
    {
        $response = $this->client->request('GET', 'https://www.biblijni.pl/');
        $crawler = new Crawler($response->getContent(false));

        $quote = '<b>' . $crawler->filter('.bibliaTresc>h4')->text() . ':</b> ';
        $quote .= preg_replace('/\d+/u', '', $crawler->filter('.bibliaTresc>p')->last()->text());

        return $quote;
    }
}
