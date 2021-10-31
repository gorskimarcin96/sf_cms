<?php

namespace App\Utils\Features\Both\Counter;

use App\Repository\CounterRepository;

class CounterStatistic
{
    private const DAYS = [30, 3 * 30, 6 * 30, 12 * 30, 10 * 12 * 30];

    public function __construct(private CounterRepository $counterRepository)
    {
    }

    public function get(): array
    {
        foreach (self::DAYS as $day) {
            $data[] = [
                'days'    => $day,
                'refresh' => $this->counterRepository->sumRefreshForDays($day),
                'entries' => $this->counterRepository->sumEntriesForDays($day),
            ];
        }

        return $data ?? [];
    }
}
