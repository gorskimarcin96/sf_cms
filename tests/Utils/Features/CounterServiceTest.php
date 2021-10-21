<?php

namespace App\Tests\Utils\Features;

use App\Repository\CounterRepository;
use App\Utils\Features\CounterService;
use DateTime;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CounterServiceTest extends KernelTestCase
{
    private CounterService $counterService;
    private CounterRepository $counterRepository;
    private string $today;

    #[NoReturn] protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->counterService = self::$kernel->getContainer()->get(CounterService::class);
        $this->counterRepository = self::$kernel->getContainer()->get(CounterRepository::class);
        $this->today = (new DateTime())->format('Y-m-d');
    }

    public function testFirstVisitPage()
    {
        $this->counterRepository->truncate();
        $this->counterService->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(1, $counter->getRefresh());
    }

    public function testSecondVisitPage()
    {
        $this->counterService->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(2, $counter->getRefresh());
    }

    public function testThirdVisitPage()
    {
        $this->counterService->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(3, $counter->getRefresh());
    }

    public function testGetChartData()
    {
        $this->assertSame([
            'days'    => 30,
            'refresh' => [
                [
                    'y' => 3,
                    'x' => $this->today,
                ],
            ],
            'entries' => [
                [
                    'y' => 1,
                    'x' => $this->today,
                ],
            ],
        ], $this->counterService->getChartData()[0]);
    }

    public function testGetStatistics()
    {
        $this->assertSame([
            'days' => 30,
            'refresh' => 3,
            'entries' => 1,
        ], $this->counterService->getStatistics()[0]);
    }

    public function testCacheData()
    {
        $this->counterService->entry();
        $this->counterService->entry();
        $this->counterService->entry();
        $this->counterService->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(7, $counter->getRefresh());

        $this->assertSame([
            'days'    => 30,
            'refresh' => [
                [
                    'y' => 3,
                    'x' => $this->today,
                ],
            ],
            'entries' => [
                [
                    'y' => 1,
                    'x' => $this->today,
                ],
            ],
        ], $this->counterService->getChartData()[0]);

        $this->assertSame([
            'days'    => 30,
            'refresh' => 3,
            'entries' => 1,
        ], $this->counterService->getStatistics()[0]);
    }
}
