<?php

namespace App\Tests\Tools\Integration\Ovh;

use App\Tools\Integration\Ovh\Client;
use App\Tools\Integration\Ovh\Model\Service;
use DateTime;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->client
            ->method('getServices')
            ->willReturn([
                new Service(1, 'fake', 'fake', new DateTime(), new DateTime(), new DateTime()),
            ]);
        $this->client->method('getName')->willReturn('OVH');
        $this->client->method('isActive')->willReturn(true);

        parent::setUp();
    }

    public function testGetName(): void
    {
        $this->assertSame('OVH', $this->client->getName());
    }

    public function testIsActive(): void
    {
        $this->assertTrue($this->client->isActive());
    }

    public function testGetServices(): void
    {
        $this->assertIsArray($this->client->getServices());
    }
}
