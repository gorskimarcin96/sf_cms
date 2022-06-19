<?php

namespace App\Tests\Tools\WebFeatures\Both\Counter;

use App\Tools\WebFeatures\Both\Counter\CounterChart;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\Chartjs\Model\Chart;

class CounterChartTest extends KernelTestCase
{
    private CounterChart $counterChart;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->counterChart = self::$kernel->getContainer()->get(CounterChart::class);
    }

    public function testGet(): void
    {
        $chart = $this->counterChart->get();
        $this->assertSame(Chart::class, get_class($chart));
        $this->assertSame(Chart::TYPE_LINE, $chart->getType());
    }
}
