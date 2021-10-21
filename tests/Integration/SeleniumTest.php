<?php

namespace App\Tests\Integration;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;

class SeleniumTest extends TestCase
{
    public function testConnect(): void
    {
        $remoteWebDriver = RemoteWebDriver::create('sf_cms-selenium-hub:4444', DesiredCapabilities::chrome());

        $this->assertIsString($remoteWebDriver->getWindowHandle());

        $remoteWebDriver->quit();
    }
}
