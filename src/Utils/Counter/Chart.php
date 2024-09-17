<?php

namespace App\Utils\Counter;

use App\Repository\CounterRepository;
use App\Utils\DateTimeManager;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart as SymfonyChart;

readonly class Chart
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private CounterRepository $counterRepository,
        private DateTimeManager $dateTimeManager
    ) {
    }

    public function get(): SymfonyChart
    {
        $days = 30;
        $labels = $this->dateTimeManager->getArrayDates(
            new \DateTime(sprintf('-%s days', $days)),
            new \DateTime('+1 days'),
            new \DateInterval('P1D')
        );

        return $this->chartBuilder->createChart(SymfonyChart::TYPE_LINE)->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => sprintf('Entry number (last %s days)', $days),
                    'backgroundColor' => 'rgba(132, 99, 255, 0.2)',
                    'borderColor' => 'rgb( 132, 99, 255)',
                    'data' => $this->prepareDataToChart(
                        $this->counterRepository->getSumEntriesWithDateLastDays($days),
                        $labels
                    ),
                ],
                [
                    'label' => sprintf('Refresh number (last %s days)', $days),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgb( 255, 99, 132)',
                    'data' => $this->prepareDataToChart(
                        $this->counterRepository->getSumRefreshWithDateLastDays($days),
                        $labels
                    ),
                ],
            ],
        ]);
    }

    /**
     * @param array<int, array<string, \DateTimeInterface>> $data
     * @param string[]                                      $labels
     *
     * @return int[]
     */
    private function prepareDataToChart(array $data, array $labels): array
    {
        $newData = array_fill_keys($labels, 0);

        foreach ($data as $datum) {
            $newData[$datum['date']->format('Y-m-d')] = $datum['value'];
        }

        ksort($newData);

        return array_values($newData);
    }
}
