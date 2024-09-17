<?php

namespace App\Tests\App\Utils\Counter;

use App\Repository\CounterRepository;
use App\Utils\Counter\Stats;
use PHPUnit\Framework\TestCase;

class StatsTest extends TestCase
{
    public function testGet(): void
    {
        $counterRepository = $this->createMock(CounterRepository::class);
        $counterRepository->method('sumRefreshForDays')
            ->willReturnMap([
                [30, 100],
                [3 * 30, 200],
                [6 * 30, 300],
                [12 * 30, 400],
                [10 * 12 * 30, 500],
            ]);
        $counterRepository->method('sumEntriesForDays')
            ->willReturnMap([
                [30, 10],
                [3 * 30, 20],
                [6 * 30, 30],
                [12 * 30, 40],
                [10 * 12 * 30, 50],
            ]);

        $stats = new Stats($counterRepository);

        $this->assertEquals([
            ['days' => 30, 'refresh' => 100, 'entries' => 10],
            ['days' => 3 * 30, 'refresh' => 200, 'entries' => 20],
            ['days' => 6 * 30, 'refresh' => 300, 'entries' => 30],
            ['days' => 12 * 30, 'refresh' => 400, 'entries' => 40],
            ['days' => 10 * 12 * 30, 'refresh' => 500, 'entries' => 50],
        ], $stats->get());
    }
}
