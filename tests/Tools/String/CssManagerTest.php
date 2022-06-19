<?php

namespace App\Tests\Tools\String;

use App\Tools\Faker\Invoker;
use App\Tools\String\CssManager;
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
