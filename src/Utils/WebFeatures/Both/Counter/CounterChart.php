<?php

namespace App\Utils\WebFeatures\Both\Counter;

use App\Repository\CounterRepository;
use App\Utils\Date\DateTimeManager;
use DateInterval;
use DateTime;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class CounterChart
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private CounterRepository     $counterRepository,
        private DateTimeManager       $dateTimeManager
    ) {
    }

    public function get(): array
    {
        foreach ([30, 360] as $days) {
            $labels = $this->dateTimeManager->getArrayDates(
                (new DateTime())->modify(sprintf('-%s days', --$days)),
                (new DateTime())->modify('+1 days'),
                new DateInterval('P1D')
            );

            $charts[] = $this->chartBuilder->createChart(Chart::TYPE_LINE)->setData([
                'labels'   => $labels,
                'datasets' => [
                    [
                        'label'           => sprintf('Liczba odświeżeń (ostatnie %s dni)', $days),
                        'backgroundColor' => 'rgba(132, 99, 255, 0.2)',
                        'borderColor'     => 'rgb( 132, 99, 255)',
                        'data'            => $this->prepareDataToChart($this->counterRepository->getSumEntriesWithDateLastDays($days), $labels),
                    ], [
                        'label'           => sprintf('Liczba wejść (ostatnie %s dni)', $days),
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor'     => 'rgb( 255, 99, 132)',
                        'data'            => $this->prepareDataToChart($this->counterRepository->getSumRefreshWithDateLastDays($days), $labels),
                    ],
                ],
            ]);
        }

        return $charts;
    }

    private function prepareDataToChart(array $data, array $labels): array
    {
        foreach ($data as $datum) {
            $newData[$datum['date']->format('Y-m-d')] = $datum['value'];
        }

        foreach ($labels as $label) {
            if (!isset($newData[$label])) {
                $newData[$label] = 0;
            }
        }

        ksort($newData);

        return array_values($newData);
    }
}
