<?php

namespace App\Utils;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

final class MessengerManager
{
    private RemoteWebDriver $driver;

    private const MESSENGER_URL = 'https://www.messenger.com/';
    private const IDS = [
        'login' => 'email',
        'password' => 'pass',
        'login_submit' => 'loginbutton',
    ];
    private const CSS_SELECTORS = [
        'chat_field' => 'div._1mf',
    ];

    public function __construct(string $seleniumUrl)
    {
        $this->driver = RemoteWebDriver::create($seleniumUrl, DesiredCapabilities::chrome());
    }

    public function __destruct()
    {
        $this->quit();
    }

    public function login(string $login, string $password)
    {
        $this->driver->get(self::MESSENGER_URL);
        $this->driver->findElement(WebDriverBy::className('selected'))->click();
        $this->driver->findElement(WebDriverBy::id(self::IDS['login']))->sendKeys($login);
        $this->driver->findElement(WebDriverBy::id(self::IDS['password']))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::id(self::IDS['login_submit']))->submit();
    }

    public function sendTextToUserUrl(array|string $text, string $url, int $delaySendMessageInSeconds = 1)
    {
        $this->driver->get($url);
        $this->waitingLoadMessengerPage();

        if (is_string($text)) {
            $text = [$text];
        }

        foreach ($text as $textLine) {
            $this->driver->findElement(WebDriverBy::cssSelector(self::CSS_SELECTORS['chat_field']))->sendKeys($textLine);
            $this->driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
            $this->waitingLoadMessengerPage();

            sleep($delaySendMessageInSeconds);
        }
    }

    private function waitingLoadMessengerPage()
    {
        $this->driver->wait()->until(
            function () {
                return count($this->driver->findElements(WebDriverBy::cssSelector(self::CSS_SELECTORS['chat_field'])));
            },
            'Error locating chat field.'
        );
    }

    public function quit()
    {
        $this->driver->quit();
    }
}
