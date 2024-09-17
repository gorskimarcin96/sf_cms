<?php

namespace App\Tests\App\Utils\Counter;

use App\Entity\Counter;
use App\Repository\CounterRepository;
use App\Utils\Counter\Logger;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testEntryCreatesNewCounter(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $counterRepository = $this->createMock(CounterRepository::class);
        $counterRepository->method('findByIPAndDateAndUrl')->willReturn(null);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->callback(function(Counter $counter): bool {
                $this->assertInstanceOf(Counter::class, $counter);
                $this->assertEquals('127.0.0.1', $counter->getIp());
                $this->assertEquals('/test-url', $counter->getUrl());
                $this->assertEquals(1, $counter->getRefresh());
                $this->assertEquals(1, $counter->getEntry());
                $this->assertNotNull($counter->getDate());
                $this->assertEquals(session_id(), $counter->getSessionId());

                return true;
            }));

        $em->expects($this->once())->method('flush');

        $logger = new Logger($em, $counterRepository);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $logger->entry('/test-url');
    }

    public function testEntryUpdatesExistingCounter(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $counterRepository = $this->createMock(CounterRepository::class);
        $existingCounter = (new Counter())->setRefresh(1)->setEntry(1);

        $counterRepository->method('findByIPAndDateAndUrl')->willReturn($existingCounter);
        $em->expects($this->once())->method('persist')->with($existingCounter);
        $em->expects($this->once())->method('flush');

        $logger = new Logger($em, $counterRepository);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        $logger->entry('/test-url');

        $this->assertEquals(1, $existingCounter->getEntry());
        $this->assertEquals(2, $existingCounter->getRefresh());
    }
}
