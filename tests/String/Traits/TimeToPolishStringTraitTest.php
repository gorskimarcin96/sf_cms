<?php

namespace App\Tests\String\Traits;

use App\String\Traits\TimeToPolishStringTrait;
use DateTime;
use PHPUnit\Framework\TestCase;
use SlopeIt\ClockMock\ClockMock;

class TimeToPolishStringTraitTest extends TestCase
{
    use TimeToPolishStringTrait;

    public function testGetStringCalculateTime0(): void
    {
        ClockMock::freeze(new DateTime('2021-02-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('', $result);
    }

    public function testGetStringCalculateTime1day(): void
    {
        ClockMock::freeze(new DateTime('2021-02-08'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 dzień', $result);
    }

    public function testGetStringCalculateTime5day(): void
    {
        ClockMock::freeze(new DateTime('2021-02-12'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('5 dni', $result);
    }

    public function testGetStringCalculateTime1months(): void
    {
        ClockMock::freeze(new DateTime('2021-03-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 miesiąc', $result);
    }

    public function testGetStringCalculateTime3months(): void
    {
        ClockMock::freeze(new DateTime('2021-05-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('3 miesiące', $result);
    }

    public function testGetStringCalculateTime5months(): void
    {
        ClockMock::freeze(new DateTime('2021-07-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('5 miesiący', $result);
    }

    public function testGetStringCalculateTime1year(): void
    {
        ClockMock::freeze(new DateTime('2022-02-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 rok', $result);
    }

    public function testGetStringCalculateTime2years(): void
    {
        ClockMock::freeze(new DateTime('2023-02-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('2 lat', $result);
    }

    public function testGetStringCalculateTime1dayAnd1month(): void
    {
        ClockMock::freeze(new DateTime('2021-03-08'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 miesiąc i 1 dzień', $result);
    }

    public function testGetStringCalculateTime2daysAnd2months(): void
    {
        ClockMock::freeze(new DateTime('2021-04-09'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('2 miesiące i 2 dni', $result);
    }

    public function testGetStringCalculateTime1yearAnd1month(): void
    {
        ClockMock::freeze(new DateTime('2022-03-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 rok i 1 miesiąc', $result);
    }

    public function testGetStringCalculateTime2yearsAnd2months(): void
    {
        ClockMock::freeze(new DateTime('2023-04-07'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('2 lat i 2 miesiące', $result);
    }

    public function testGetStringCalculateTime1yearAnd1day(): void
    {
        ClockMock::freeze(new DateTime('2022-02-08'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 rok i 1 dzień', $result);
    }

    public function testGetStringCalculateTime2yearsAnd2days(): void
    {
        ClockMock::freeze(new DateTime('2023-02-09'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('2 lat i 2 dni', $result);
    }

    public function testGetStringCalculateTime1yearAnd1mounthAnd1day(): void
    {
        ClockMock::freeze(new DateTime('2022-03-08'));
        $result = $this->getStringCalculateTime(new DateTime('2021-02-07'));

        $this->assertEquals('1 rok, 1 miesiąc i 1 dzień', $result);
    }
}
