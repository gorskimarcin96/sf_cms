<?php

namespace App\Tests\Utils\Features\Both\Counter;

use App\Tests\Invoker;
use App\Utils\Date\DateTimeManager;
use App\Utils\Features\Both\Counter\CounterChart;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\Chartjs\Model\Chart;

class CounterChartTest extends KernelTestCase
{
    use Invoker;

    private CounterChart $counterChart;
    private DateTimeManager $dateTimeManager;

    #[NoReturn] protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->counterChart = self::$kernel->getContainer()->get(CounterChart::class);
        $this->dateTimeManager = self::$kernel->getContainer()->get(DateTimeManager::class);
    }

    public function testGet()
    {
        foreach ($this->counterChart->get() as $key => $chart) {
            $this->assertSame(Chart::class, get_class($chart));
            $this->assertSame(Chart::TYPE_LINE, $chart->getType());
            $this->assertSame($key === 0 ? 30 : 360, count($chart->getData()['datasets'][0]['data']));
            $this->assertSame($key === 0 ? 30 : 360, count($chart->getData()['datasets'][1]['data']));
        }
    }
}
