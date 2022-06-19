<?php

namespace App\Tools\Date;

use DateInterval;
use DatePeriod;
use DateTime;

class DateTimeManager
{
    public function getArrayDates(DateTime $start, DateTime $end, DateInterval $dateInterval, string $format = 'Y-m-d'): array
    {
        foreach (new DatePeriod($start, $dateInterval, $end) as $dateTime) {
            $dates[] = $dateTime->format($format);
        }

        return $dates ?? [];
    }
}
