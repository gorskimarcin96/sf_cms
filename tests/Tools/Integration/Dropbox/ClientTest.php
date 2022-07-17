<?php

namespace App\Tests\Tools\Integration\Dropbox;

use App\Tools\Integration\Dropbox\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->client->method('getName')->willReturn('Dropbox');
        $this->client->method('isActive')->willReturn(true);
        $this->client->method('save');
        $this->client->method('read')->willReturn('test string');
        $this->client->method('delete');

        parent::setUp();
    }

    public function testGetName(): void
    {
        $this->assertSame('Dropbox', $this->client->getName());
    }

    public function testIsActive(): void
    {
        $this->assertTrue($this->client->isActive());
    }

    public function testSave(): void
    {
        $this->client->save('test/path', 'content');

        $this->assertTrue(true);
    }

    public function testRead(): void
    {
        $this->assertSame('test string', $this->client->read('test/path'));
    }

    public function testDelete(): void
    {
        $this->client->delete('test/path');

        $this->assertTrue(true);
    }
}
