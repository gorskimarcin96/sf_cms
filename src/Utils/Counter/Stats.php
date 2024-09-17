<?php

namespace App\Utils\Counter;

use App\Repository\CounterRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

readonly class Stats
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
        return array_map(fn (int $days): array => [
            'days' => $days,
            'refresh' => $this->counterRepository->sumRefreshForDays($days),
            'entries' => $this->counterRepository->sumEntriesForDays($days),
        ], self::DAYS);
    }
}
