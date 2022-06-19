<?php

namespace App\Tests\Tools\Crawler;

use App\Tools\Crawler\Ofeminin;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OfemininTest extends KernelTestCase
{
    private Ofeminin $ofeminin;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->ofeminin = self::$kernel->getContainer()->get(Ofeminin::class);
    }
    public function testGetAll(): void
    {
        $data = $this->ofeminin->getAll()->current();

        $this->assertIsString($data['title']);
        $this->assertIsString($data['image']);
        $this->assertIsString($data['sections'][0]);
        $this->assertIsString($data['sections'][1]);
    }

    public function testCountUrls(): void
    {
        $this->assertTrue($this->ofeminin->countUrls() > 0);
    }
}
