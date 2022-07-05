<?php

namespace App\Tools\Crawler\Camasutra;

use App\Tools\String\StringConverter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Ofeminin implements CamasutraInterface
{
    public const PAGE = 'https://www.ofeminin.pl/milosc/kamasutra-wszystkie-pozycje';

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function getAll(): iterable
    {
        foreach ($this->getUrls() as $url) {
            $response = $this->client->request('GET', $url);
            $crawler = new Crawler($response->getContent(false));
            $image = $crawler->filter('img.lmImg')->attr('src');
            $sections = [];

            foreach ([$crawler->filter('.lead')->html(), $crawler->filter('.whitelistPremium')->html()] as $html) {
                $sections[] = (new StringConverter($html))->removeMultiSpaces()->removeMultilines()->removeHtmlTag('script')->toString();
            }

            yield [
                'title' => $crawler->filter('h1')->text(),
                'image' => str_contains($image, 'http:') ? $image : ('http:' . $image),
                'sections' => $sections
            ];
        }
    }

    public function countUrls(): int
    {
        return count($this->getUrls());
    }

    private function getUrls(): array
    {
        $response = $this->client->request('GET', self::PAGE);
        $crawler = new Crawler($response->getContent(false));
        $lastPage = $crawler->filter('ul.paginatorUl>li.paginatorLi')->last()->text();

        foreach (range(1, $lastPage) as $page) {
            $response = $this->client->request('GET', self::PAGE . '?page=' . $page);
            $crawler = new Crawler($response->getContent(false));

            $newUrls = $crawler->filter('.stream a')->each(function (Crawler $node, $i) {
                return $node->attr('href');
            });

            $urls = array_merge($newUrls, $urls ?? []);
        }

        return $urls ?? [];
    }

    public function isCountable(): bool
    {
        return true;
    }
}
