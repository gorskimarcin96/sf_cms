<?php

declare(strict_types=1);

namespace App\Utils;

class DateTimeManager
{
    /** @return string[] */
    public function getArrayDates(
        \DateTime $start,
        \DateTime $end,
        \DateInterval $dateInterval,
        string $format = 'Y-m-d',
    ): array {
        return array_map(fn ($dateTime) => $dateTime->format($format), iterator_to_array(new \DatePeriod($start, $dateInterval, $end)));
    }
}
