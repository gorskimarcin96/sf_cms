<?php

namespace App\Utils\Counter;

use App\Repository\CounterRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class CounterStatistic
{
    private const DAYS = [30, 3 * 30, 6 * 30, 12 * 30, 10 * 12 * 30];

    public function __construct(private CounterRepository $counterRepository)
    {
    }

    /**
     * @return array<int, array{days: int, refresh: bool|float|int|string, entries: int}>
     *
     * @throws NoResultException|NonUniqueResultException
     */
    public function get(): array
    {
        $data = [];

        foreach (self::DAYS as $day) {
            $data[] = [
                'days' => $day,
                'refresh' => $this->counterRepository->sumRefreshForDays($day),
                'entries' => $this->counterRepository->sumEntriesForDays($day),
            ];
        }

        return $data;
    }
}
