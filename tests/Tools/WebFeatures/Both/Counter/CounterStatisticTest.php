<?php

namespace App\Tests\Tools\WebFeatures\Both\Counter;

use App\Tools\WebFeatures\Both\Counter\CounterStatistic;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CounterStatisticTest extends KernelTestCase
{
    private CounterStatistic $counterStatistic;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->counterStatistic = self::$kernel->getContainer()->get(CounterStatistic::class);
    }

    public function testGet(): void
    {
        $this->assertSame([
            ['days' => 30, 'refresh' => 3, 'entries' => 1],
            ['days' => 90, 'refresh' => 3, 'entries' => 1],
            ['days' => 180, 'refresh' => 3, 'entries' => 1],
            ['days' => 360, 'refresh' => 3, 'entries' => 1],
            ['days' => 3600, 'refresh' => 3, 'entries' => 1],
        ], $this->counterStatistic->get());
    }
}
