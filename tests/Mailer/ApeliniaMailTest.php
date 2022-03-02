<?php

namespace App\Tests\Mailer;

use App\Mailer\ApeliniaMail;
use App\Tests\Invoker;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApeliniaMailTest extends KernelTestCase
{
    use Invoker;

    private ApeliniaMail $apeliniaMail;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->apeliniaMail = self::$kernel->getContainer()->get(ApeliniaMail::class);
    }
    public function testCreate(): void
    {
        $this->assertInstanceOf(TemplatedEmail::class, $this->apeliniaMail->create());
    }

    public function testGetApeliniaTime0(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-02-07')]);

        $this->assertEquals('', $result);
    }

    public function testGetApeliniaTime1day(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-02-08')]);

        $this->assertEquals('1 dzień', $result);
    }

    public function testGetApeliniaTime5day(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-02-12')]);

        $this->assertEquals('5 dni', $result);
    }

    public function testGetApeliniaTime1months(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-03-07')]);

        $this->assertEquals('1 miesiąc', $result);
    }

    public function testGetApeliniaTime3months(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-05-07')]);

        $this->assertEquals('3 miesiące', $result);
    }

    public function testGetApeliniaTime5months(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-07-07')]);

        $this->assertEquals('5 miesiący', $result);
    }

    public function testGetApeliniaTime1year(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2022-02-07')]);

        $this->assertEquals('1 rok', $result);
    }

    public function testGetApeliniaTime2years(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2023-02-07')]);

        $this->assertEquals('2 lat', $result);
    }

    public function testGetApeliniaTime1dayAnd1month(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-03-08')]);

        $this->assertEquals('1 miesiąc i 1 dzień', $result);
    }

    public function testGetApeliniaTime2daysAnd2months(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2021-04-09')]);

        $this->assertEquals('2 miesiące i 2 dni', $result);
    }

    public function testGetApeliniaTime1yearAnd1month(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2022-03-07')]);

        $this->assertEquals('1 rok i 1 miesiąc', $result);
    }

    public function testGetApeliniaTime2yearsAnd2months(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2023-04-07')]);

        $this->assertEquals('2 lat i 2 miesiące', $result);
    }

    public function testGetApeliniaTime1yearAnd1day(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2022-02-08')]);

        $this->assertEquals('1 rok i 1 dzień', $result);
    }

    public function testGetApeliniaTime2yearsAnd2days(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2023-02-09')]);

        $this->assertEquals('2 lat i 2 dni', $result);
    }

    public function testGetApeliniaTime1yearAnd1mounthAnd1day(): void
    {
        $result = $this->invokeMethod($this->apeliniaMail, 'getApeliniaTime', [], ['now' => new DateTime('2022-03-08')]);

        $this->assertEquals('1 rok, 1 miesiąc i 1 dzień', $result);
    }
}
