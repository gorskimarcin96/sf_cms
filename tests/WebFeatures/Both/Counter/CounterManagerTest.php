<?php

namespace App\Tests\WebFeatures\Both\Counter;

use App\Faker\Invoker;
use App\Repository\CounterRepository;
use App\WebFeatures\Both\Counter\CounterManager;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CounterManagerTest extends KernelTestCase
{
    use Invoker;

    private CounterManager $counterManager;
    private CounterRepository $counterRepository;
    private string $today;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $_SERVER['HTTP_CLIENT_IP'] = '255.20.0.0';
        $this->counterManager = self::$kernel->getContainer()->get(CounterManager::class);
        $this->counterRepository = self::$kernel->getContainer()->get(CounterRepository::class);
        $this->today = (new DateTime())->format('Y-m-d');
    }

    public function testGetIp(): void
    {
        $this->assertEquals($_SERVER['HTTP_CLIENT_IP'], $this->invokeMethod($this->counterManager, 'getIp', [false]));
    }

    public function testGetIpLong(): void
    {
        $this->assertEquals(4279500800, $this->invokeMethod($this->counterManager, 'getIp', [true]));
    }

    public function testGetIpAnonym(): void
    {
        unset($_SERVER['HTTP_CLIENT_IP']);

        $this->assertEquals('anonym', $this->invokeMethod($this->counterManager, 'getIp'));
    }

    public function testFirstVisitPage(): void
    {
        $this->counterRepository->truncate();
        $this->counterManager->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(1, $counter->getRefresh());
    }

    public function testSecondVisitPage(): void
    {
        $this->counterManager->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(2, $counter->getRefresh());
    }

    public function testThirdVisitPage(): void
    {
        $this->counterManager->entry();

        $counter = $this->counterRepository->findOneBy([]);

        $this->assertSame($this->today, $counter->getDate()->format('Y-m-d'));
        $this->assertSame(1, $counter->getEntry());
        $this->assertSame(3, $counter->getRefresh());
    }
}
