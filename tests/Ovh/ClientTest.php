<?php

namespace App\Tests\Ovh;

use App\Crawler\Facebook\DogJokes;
use App\Ovh\Client;
use App\Ovh\Model\Service;
use DateTime;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGetServices(): void
    {
        $client = $this->createMock(Client::class);
        $client
            ->method('getServices')
            ->willReturn([
                new Service(1, 'fake', 'fake', new DateTime(), new DateTime(), new DateTime()),
            ]);

        $this->assertIsArray($client->getServices());
    }
}
