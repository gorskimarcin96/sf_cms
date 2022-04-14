<?php

namespace App\Task\Messenger;

use App\Crawler\Facebook\Facebook;
use ErrorException;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use TypeError;

final class MessengerManager extends Facebook
{
    private const CHAT_FIELD = 'chat_field';
    private const CSS_SELECTORS = [
        self::CHAT_FIELD => 'div._1mf',
    ];

    public function sendTextToUserUrl(array|string $text, string $url, int $delaySendMessageInSeconds = 1): void
    {
        $this->client->get($url);
        $this->waitingLoadMessengerPage();

        $text = is_string($text) ? [$text] : $text;

        foreach ($text as $textLine) {
            try {
                $this->client->findElement(WebDriverBy::cssSelector(self::CSS_SELECTORS[self::CHAT_FIELD]))->sendKeys($textLine);
                $this->messengerLogger->notice('Text "' . $textLine . '" is sended.');
            } catch (TypeError $typeError) {
                $this->messengerLogger->error('Cannot set "' . $textLine . '" to chat form.');
            } finally {
                $this->client->getKeyboard()->pressKey(WebDriverKeys::ENTER);
                sleep($delaySendMessageInSeconds);
            }
            $this->waitingLoadMessengerPage();
        }
    }

    private function waitingLoadMessengerPage(): void
    {
        try {
            $this->client->wait()->until(
                function () {
                    return count($this->client->findElements(WebDriverBy::cssSelector(self::CSS_SELECTORS[self::CHAT_FIELD])));
                },
                'Error locating chat field.'
            );
        } catch (ErrorException $errorException) {
            $this->messengerLogger->error('Cannot waiting for page, chat is not founded.');
        }
    }
}
