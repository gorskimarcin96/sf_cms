<?php

namespace App\Tests\Utils\Date;

use App\Utils\Date\DateTimeManager;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeManagerTest extends TestCase
{
    public function testGetArrayDates()
    {
        $dateTimeManager = new DateTimeManager();
        $result = $dateTimeManager->getArrayDates(
            new DateTime('2000-01-01'),
            new DateTime('2000-01-07'),
            new DateInterval('P1D')
        );

        $this->assertSame(['2000-01-01', '2000-01-02', '2000-01-03', '2000-01-04', '2000-01-05', '2000-01-06'], $result);
    }
}
