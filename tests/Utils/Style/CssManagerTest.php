<?php

namespace App\Tests\Utils\Style;

use App\Tests\Invoker;
use App\Utils\Style\CssManager;
use PHPUnit\Framework\TestCase;

class CssManagerTest extends TestCase
{
    use Invoker;

    public function testRandGradient()
    {
        $cssManager = new CssManager();

        $this->assertIsString($cssManager->randGradient());
    }

    public function testRandColor()
    {
        $cssManager = new CssManager();

        $this->assertIsString($this->invokeMethod($cssManager, 'randColor'));
    }
}
