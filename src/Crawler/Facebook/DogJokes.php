<?php

namespace App\Crawler\Facebook;

use App\Crawler\Facebook\Exception\ImageNotFoundException;
use App\DBAL\Types\LocaleType;
use Facebook\WebDriver\Exception\StaleElementReferenceException;
use Facebook\WebDriver\WebDriver;

class DogJokes extends Facebook
{
    public const DOG_JOKES_URL = 'https://www.facebook.com/psiesucharki/photos/a.808522252533944/808522172533952';
    public const IMG_ELEMENT = 'img[data-visualcompletion="media-vc-image"]';
    public const JAVASCRIPT_CLICK_PREV = [
        LocaleType::ENGLISH => "document.querySelectorAll('div[aria-label=\"Previous photo\"]')[0].click()",
        LocaleType::POLISH  => "document.querySelectorAll('div[aria-label=\"Poprzednie zdjęcie\"]')[0].click()",
    ];

    /**
     * @throws ImageNotFoundException
     * @throws LoginIsRequiredException
     */
    public function getAll(?string $url = null): iterable
    {
        if (!$this->clientIsExists() || !$this->isLogged()) {
            throw new LoginIsRequiredException();
        }

        $url = $url ?? self::DOG_JOKES_URL;
        $actualUrl = null;
        $this->client->request('GET', $url);
        $this->client->waitFor(self::IMG_ELEMENT);

        while ($url !== $actualUrl) {
            $this->client->executeScript(self::JAVASCRIPT_CLICK_PREV[$this->getLocale()]);
            $this->client->waitFor(self::IMG_ELEMENT);
            $actualUrl = $this->client->getCurrentURL();
            $this->messengerLogger->notice('Get image from: ' . $actualUrl);

            yield $this->toArray($this->client);
        }
    }

    /** @throws ImageNotFoundException */
    private function toArray(WebDriver $webDriver): array
    {
        try {
            return [
                'url'   => $webDriver->getCurrentURL(),
                'image' => $webDriver->getCrawler()->filter(self::IMG_ELEMENT)->images()[0]->getUri(),
            ];
        } catch (StaleElementReferenceException $exception) {
            throw new ImageNotFoundException();
        }
    }
}
