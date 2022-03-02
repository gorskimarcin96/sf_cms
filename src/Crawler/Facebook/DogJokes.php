<?php

namespace App\Crawler\Facebook;

use Facebook\WebDriver\Exception\StaleElementReferenceException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\WebDriverCurlException;
use Facebook\WebDriver\Exception\WebDriverException;
use Symfony\Component\Panther\Client;

class DogJokes
{
    public const DOG_JOKES_URL = 'https://www.facebook.com/psiesucharki/photos/a.808522252533944/808522172533952';
    public const IMG_ELEMENT = 'img[data-visualcompletion="media-vc-image"]';
    public const JAVASCRIPT_CLICK_PREV = "document.querySelectorAll('div[aria-label=\"Previous photo\"]')[0].click()";

    public function __construct(private string $seleniumUrl)
    {
    }

    /**
     * @throws TimeoutException
     * @throws WebDriverException
     * @throws WebDriverCurlException
     * @throws StaleElementReferenceException
     */
    public function getAll(?string $url = null): iterable
    {
        $url = $url ?? self::DOG_JOKES_URL;
        $actualUrl = null;
        $customSeleniumClient = Client::createSeleniumClient($this->seleniumUrl);
        $customSeleniumClient->request('GET', $url);
        $customSeleniumClient->waitFor(self::IMG_ELEMENT);

        while ($url !== $actualUrl) {
            $actualUrl = $customSeleniumClient->getCurrentURL();
            $customSeleniumClient->executeScript(self::JAVASCRIPT_CLICK_PREV);
            $customSeleniumClient->waitFor(self::IMG_ELEMENT);

            yield $this->toArray($customSeleniumClient);
        }
    }

    private function toArray(Client $customSeleniumClient): array
    {
        return [
            'url'   => $customSeleniumClient->getCurrentURL(),
            'image' => $customSeleniumClient->getCrawler()->filter(self::IMG_ELEMENT)->images()[0]->getUri(),
        ];
    }
}
