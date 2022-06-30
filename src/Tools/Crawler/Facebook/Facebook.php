<?php

namespace App\Tools\Crawler\Facebook;

use App\DBAL\Types\LocaleType;
use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Psr\Log\LoggerInterface;
use Symfony\Component\Panther\Client;
use TypeError;

abstract class Facebook
{
    public const MESSENGER_URL = 'https://www.messenger.com/';
    public const FACEBOOK_URL = 'https://facebook.com/';
    private const LOGIN_ID = 'login';
    private const PASSWORD_ID = 'password';
    private const LOGIN_SUBMIT_ID = 'login_submit';
    private const IDS = [
        self::LOGIN_ID        => 'email',
        self::PASSWORD_ID     => 'pass',
        self::LOGIN_SUBMIT_ID => 'loginbutton',
    ];

    protected ?WebDriver $client = null;
    private bool $isLogged = false;
    private string $locale = LocaleType::ENGLISH;

    public function __construct(private string $seleniumUrl, protected LoggerInterface $messengerLogger)
    {
    }

    public function __destruct()
    {
        $this->close();
    }

    public function createClient(): void
    {
        if (!$this->clientIsExists()) {
            $this->client = Client::createSeleniumClient($this->seleniumUrl);
        }
    }

    public function clientIsExists(): bool
    {
        return null !== $this->client;
    }

    public function login(string $login, string $password, string $url = self::FACEBOOK_URL): void
    {
        $this->client->get($url);
        $this->clickCookieConfirm();

        if (!$this->checkIsLogged()) {
            try {
                $this->client->findElement(WebDriverBy::id(self::IDS[self::LOGIN_ID]))->sendKeys($login);
                $this->client->findElement(WebDriverBy::id(self::IDS[self::PASSWORD_ID]))->sendKeys($password);
                $this->client->findElement(WebDriverBy::id(self::IDS[self::LOGIN_SUBMIT_ID]))->submit();

                $this->messengerLogger->notice('User ' . $login . ' is logged.');
                $this->isLogged = true;
            } catch (TypeError $typeError) {
                $this->messengerLogger->error('User ' . $login . ' is not logged.');
            }
        }

        $this->clickCookieConfirm();
    }

    private function clickCookieConfirm(): void
    {
        sleep(1);
        $break = false;

        try {
            foreach ($this->client->findElements(WebDriverBy::className('selected')) as $element) {
                if (str_contains($element->getText(), 'cookies')) {
                    $break = true;
                    $element->click();

                    break;
                }
            }

            if (!$break) {
                $elements = array_reverse($this->client->findElements(WebDriverBy::tagName('span')));

                foreach ($elements as $element) {
                    if (str_contains($element->getText(), 'cookie')) {
                        $break = true;
                        $this->client->executeScript("document.querySelectorAll('span[class=\"".$element->getAttribute('class')."\"]')[0].click()");
                        break;
                    }
                }
            }
        } catch (TypeError $exception) {
            $this->messengerLogger->notice('Confirm is not clicked.');
        }

        $this->messengerLogger->notice($break ? 'Cookie confirm is clicked.' : 'Cookie confirm is not found.');
    }

    public function checkIsLogged(): bool
    {
        try {
            $this->client->findElement(WebDriverBy::id(self::IDS[self::LOGIN_SUBMIT_ID]));
            $this->messengerLogger->notice('User is probably not logged.');
            $this->isLogged = false;
        } catch (WebDriverException $exception) {
            $this->messengerLogger->notice('User is probably logged.');
            $this->isLogged = true;
        }

        return $this->isLogged;
    }

    public function isLogged(): bool
    {
        return $this->isLogged;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function close(): void
    {
        if ($this->clientIsExists()) {
            $this->client->close();
            $this->client->quit();
            $this->messengerLogger->notice('Page is closed.');
        }
    }
}
