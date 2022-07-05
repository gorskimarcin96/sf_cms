<?php

namespace App\Tests\Tools\Crawler\Camasutra;

use App\Tools\Crawler\Camasutra\ZdrowieGazeta;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ZdrowieGazetaTest extends KernelTestCase
{
    private ZdrowieGazeta $service;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->service = self::$kernel->getContainer()->get(ZdrowieGazeta::class);
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
        $this->expectException(RuntimeException::class);

        $this->service->countUrls();
    }

    public function testIsCountable(): void
    {
        $this->assertFalse($this->service->isCountable());
    }
}
