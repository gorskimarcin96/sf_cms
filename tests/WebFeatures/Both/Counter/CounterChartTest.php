<?php

namespace App\Tests\WebFeatures\Both\Counter;

use App\Date\DateTimeManager;
use App\Faker\Invoker;
use App\WebFeatures\Both\Counter\CounterChart;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\Chartjs\Model\Chart;

class CounterChartTest extends KernelTestCase
{
    use Invoker;

    private CounterChart $counterChart;
    private DateTimeManager $dateTimeManager;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->counterChart = self::$kernel->getContainer()->get(CounterChart::class);
        $this->dateTimeManager = self::$kernel->getContainer()->get(DateTimeManager::class);
    }

    public function testGet(): void
    {
        foreach ($this->counterChart->get() as $key => $chart) {
            $this->assertSame(Chart::class, get_class($chart));
            $this->assertSame(Chart::TYPE_LINE, $chart->getType());
            $this->assertCount($key === 0 ? 30 : 360, $chart->getData()['datasets'][0]['data']);
            $this->assertCount($key === 0 ? 30 : 360, $chart->getData()['datasets'][1]['data']);
        }
    }
}
