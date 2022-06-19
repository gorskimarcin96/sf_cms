<?php

namespace App\Tests\Tools\Crawler\Facebook;

use App\Tools\Crawler\Facebook\DogJokes;
use PHPUnit\Framework\TestCase;

class DogJokesTest extends TestCase
{
    public function testGetAll(): void
    {
        $dogJokes = $this->createMock(DogJokes::class);
        $dogJokes
            ->method('getAll')
            ->willReturn([['url' => 'url', 'img' => 'img']]);

        $this->assertSame($dogJokes->getAll(), [['url' => 'url', 'img' => 'img']]);
    }
}
