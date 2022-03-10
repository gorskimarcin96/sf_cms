<?php

namespace App\String\Traits;

use DateInterval;
use DateTime;

trait TimeToPolishStringTrait
{
    public function getStringCalculateTime(DateTime $dateTime): string
    {
        $now = new DateTime();
        $date = '';
        $years = $dateTime->diff($now)->y;
        $dateTime->add(
            new DateInterval(sprintf("P%sY", $dateTime->diff($now)->y))
        );
        $months = $dateTime->diff($now)->m;
        $dateTime->add(
            new DateInterval(sprintf("P%sM", $dateTime->diff($now)->m))
        );
        $days = $dateTime->diff($now)->d;

        if ($years === 1) {
            $date .= $years.' rok';
        } elseif ($years > 1) {
            $date .= $years.' lat';
        }

        if ($months) {
            if ($years) {
                $date .= $days ? ', ' : ' i ';
            }

            if ($months === 1) {
                $date .= $months.' miesiąc';
            } elseif (in_array($months, [2, 3, 4])) {
                $date .= $months.' miesiące';
            } elseif ($months > 0) {
                $date .= $months.' miesiący';
            }
        }

        if ($days) {
            if ($years || $months) {
                $date .= ' i ';
            }

            $date .= $days === 1 ? $days.' dzień' : $days.' dni';
        }

        return $date;
    }
}