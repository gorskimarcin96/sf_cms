<?php

namespace App\Task\Messenger;

use ErrorException;
use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Psr\Log\LoggerInterface;
use TypeError;

final class MessengerManager
{
    private RemoteWebDriver $driver;

    private const MESSENGER_URL = 'https://www.messenger.com/';
    private const IDS = [
        'login'        => 'email',
        'password'     => 'pass',
        'login_submit' => 'loginbutton',
    ];
    private const CSS_SELECTORS = [
        'chat_field' => 'div._1mf',
    ];

    public function __construct(string $seleniumUrl, private LoggerInterface $messengerLogger)
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

        if (!$this->checkIsLogged()) {
            try {
                $this->driver->findElement(WebDriverBy::className('selected'))->click();
                $this->messengerLogger->notice('Confirm is clicked.');
            } catch (TypeError $exception) {
                $this->messengerLogger->notice('Confirm is not clicked.');
            }

            try {
                $this->driver->findElement(WebDriverBy::id(self::IDS['login']))->sendKeys($login);
                $this->driver->findElement(WebDriverBy::id(self::IDS['password']))->sendKeys($password);
                $this->driver->findElement(WebDriverBy::id(self::IDS['login_submit']))->submit();
                $this->messengerLogger->notice('User ' . $login . ' is logged.');
            } catch (TypeError $typeError) {
                $this->messengerLogger->error('User ' . $login . ' is not logged.');
            }
        }
    }

    public function sendTextToUserUrl(array|string $text, string $url, int $delaySendMessageInSeconds = 1)
    {
        $this->driver->get($url);
        $this->waitingLoadMessengerPage();

        $text = is_string($text) ? [$text] : $text;

        foreach ($text as $textLine) {
            try {
                $this->driver->findElement(WebDriverBy::cssSelector(self::CSS_SELECTORS['chat_field']))->sendKeys($textLine);
                $this->messengerLogger->notice('Text "' . $textLine . '" is sended.');
            } catch (TypeError $typeError) {
                $this->messengerLogger->error('Cannot set "' . $textLine . '" to chat form.');
            } finally {
                $this->driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
                sleep($delaySendMessageInSeconds);
            }
            $this->waitingLoadMessengerPage();
        }
    }

    private function waitingLoadMessengerPage()
    {
        try {
            $this->driver->wait()->until(
                function () {
                    return count($this->driver->findElements(WebDriverBy::cssSelector(self::CSS_SELECTORS['chat_field'])));
                },
                'Error locating chat field.'
            );
        } catch (ErrorException $errorException) {
            $this->messengerLogger->error('Cannot waiting for page, chat is not founded.');
        }
    }

    private function quit()
    {
        $this->messengerLogger->notice('Page is closed.');
        $this->driver->quit();
    }

    private function checkIsLogged(): bool
    {
        try {
            $this->driver->findElement(WebDriverBy::id(self::IDS['login_submit']));
            $this->messengerLogger->notice('User is probably not logged.');

            return false;
        } catch (WebDriverException $exception) {
            $this->messengerLogger->notice('User is probably logged.');

            return true;
        }
    }
}
