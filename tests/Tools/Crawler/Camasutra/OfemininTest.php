<?php

namespace App\Tests\Tools\Crawler\Camasutra;

use App\Tools\Crawler\Camasutra\Ofeminin;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OfemininTest extends KernelTestCase
{
    private Ofeminin $service;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->service = self::$kernel->getContainer()->get(Ofeminin::class);
    }

    public function testGetAll(): void
    {
        $data = $this->service->getAll()->current();

        $this->assertIsString($data['title']);
        $this->assertIsString($data['image']);
        $this->assertIsString($data['sections'][0]);
        $this->assertIsString($data['sections'][1]);
    }

    public function testCountUrls(): void
    {
        $this->assertTrue($this->service->countUrls() > 0);
    }

    public function testIsCountable(): void
    {
        $this->assertTrue($this->service->isCountable());
    }
}
