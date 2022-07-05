<?php

namespace App\Tools\Crawler\Camasutra;

use App\Tools\String\StringConverter;
use App\Tools\String\Validator;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ZdrowieGazeta implements CamasutraInterface
{
    public const PAGES = [
        'https://zdrowie.gazeta.pl/Zdrowie/56,105817,19760083,gdy-serce-nie-sluga-a-w-biodrze-lupie-czyli-pozycje-seksualne.html',
        'https://zdrowie.gazeta.pl/Zdrowie/56,105817,21799253,nie-tylko-na-pieska-25-pozycji-seksualnych-od-tylu-takze-dla.html',
    ];

    public function __construct(private HttpClientInterface $client, private Validator $stringValidator)
    {
    }

    public function getAll(): iterable
    {
        foreach (self::PAGES as $url) {
            $response = $this->client->request('GET', $url);
            $content = (new StringConverter($response->getContent()))
                ->mbConvertEncoding('ISO-8859-2', 'UTF-8')
                ->toString();

            foreach ((new Crawler($content))->filter('.fs_photo_box')->each(function (Crawler $node) {
                $title = (new StringConverter($node->filter('h2')->text()))->removeToStart('Pozycja');
                $title->trim()->ucfirst();
                $newDescription = '';
                $descriptionNodes = $node->filter('.fs_photo_box_desc>p')->each(function (Crawler $node) {
                    return $node;
                });

                foreach ($descriptionNodes as $descriptionNode) {
                    if ($this->stringValidator->contains(
                        $descriptionNode->text(),
                        ['Zobacz także:', 'Czytaj też:', 'Czytaj o', 'Czytaj:', 'Chcecie wyzwań? ', 'Zobacz:']
                    )) {
                        break;
                    }

                    $linkTexts = $descriptionNode->filter('a')->each(function (Crawler $node) {
                        return trim($node->text());
                    });
                    if (in_array(trim($descriptionNode->text()), $linkTexts)) {
                        continue;
                    }

                    $newDescription .= '<p>'.$descriptionNode->html().'</p>';
                }

                $description = new StringConverter($newDescription);
                $description
                    ->removeHtmlTag('script')
                    ->removeHtmlTag('a', false)
                    ->removeHtmlAttr('style')
                    ->remove(['(np. jak tu)'])
                    ->trim();

                return [
                    'title' => $title->toString(),
                    'image' => $node->filter('img')->attr('data-src'),
                    'sections' => [$description->toString(), ''],
                ];
            }) as $key => $datum) {
                if ($key === 0) {
                    continue;
                }

                yield $datum;
            }
        }
    }

    public function countUrls(): int
    {
        throw new RuntimeException('This service is not countable.');
    }

    public function isCountable(): bool
    {
        return false;
    }
}
