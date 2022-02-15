<?php

namespace App\Tests\String;

use App\String\CssManager;
use App\Tests\Invoker;
use PHPUnit\Framework\TestCase;

class CssManagerTest extends TestCase
{
    use Invoker;

    public function testRandGradient(): void
    {
        $cssManager = new CssManager();

        $this->assertIsString($cssManager->randGradient());
    }

    public function testRandColor(): void
    {
        $cssManager = new CssManager();

        $this->assertIsString($this->invokeMethod($cssManager, 'randColor'));
    }
}
