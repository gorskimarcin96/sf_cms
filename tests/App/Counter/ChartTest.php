<?php

namespace App\Tests\App\Utils\Counter;

use App\Repository\CounterRepository;
use App\Utils\Counter\Chart;
use App\Utils\DateTimeManager;
use PHPUnit\Framework\TestCase;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart as SymfonyChart;

class ChartTest extends TestCase
{
    public function testGet(): void
    {
        $chartBuilderMock = $this->createMock(ChartBuilderInterface::class);
        $counterRepositoryMock = $this->createMock(CounterRepository::class);
        $dateTimeManagerMock = $this->createMock(DateTimeManager::class);

        $days = 30;
        $labels = ['2023-07-25', '2023-07-26', '2023-07-27'];

        $dateTimeManagerMock->expects($this->once())
            ->method('getArrayDates')
            ->willReturn($labels);

        $counterRepositoryMock->expects($this->once())
            ->method('getSumEntriesWithDateLastDays')
            ->with($days)
            ->willReturn([
                ['date' => new \DateTime('2023-07-25'), 'value' => 5],
                ['date' => new \DateTime('2023-07-26'), 'value' => 7],
            ]);

        $counterRepositoryMock->expects($this->once())
            ->method('getSumRefreshWithDateLastDays')
            ->with($days)
            ->willReturn([
                ['date' => new \DateTime('2023-07-25'), 'value' => 3],
                ['date' => new \DateTime('2023-07-26'), 'value' => 4],
            ]);

        $chartMock = $this->createMock(SymfonyChart::class);
        $chartMock->expects($this->once())
            ->method('setData')
            ->with([
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Entry number (last 30 days)',
                        'backgroundColor' => 'rgba(132, 99, 255, 0.2)',
                        'borderColor' => 'rgb( 132, 99, 255)',
                        'data' => [5, 7, 0],
                    ],
                    [
                        'label' => 'Refresh number (last 30 days)',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgb( 255, 99, 132)',
                        'data' => [3, 4, 0],
                    ],
                ],
            ])
            ->willReturnSelf();

        $chartBuilderMock->expects($this->once())
            ->method('createChart')
            ->with(SymfonyChart::TYPE_LINE)
            ->willReturn($chartMock);

        $chart = new Chart($chartBuilderMock, $counterRepositoryMock, $dateTimeManagerMock);
        $result = $chart->get();

        $this->assertInstanceOf(SymfonyChart::class, $result);
    }
}
