<?php

namespace App\Tests\Tools\Crawler\Mem;

use App\Tools\Crawler\Mem\Demotywatory;
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

    public function testGetLinkToRandMem(): void
    {
        $this->assertIsString($this->demotywatory->getLinkToRandMem());
    }
}
