<?php

namespace App\Tests\Utils\Crawler\Mem;

use App\Utils\Crawler\Mem\Demotywatory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DemotywatoryTest extends KernelTestCase
{
    private Demotywatory $demotywatory;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->demotywatory = self::$kernel->getContainer()->get(Demotywatory::class);
    }

    public function testGetLinkToRandMem()
    {
        $this->assertIsString($this->demotywatory->getLinkToRandMem());
    }
}
