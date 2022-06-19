<?php

namespace App\Tests\Tools\Crawler\Mem;

use App\Tools\Crawler\Mem\Kwejk;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class KwejkTest extends KernelTestCase
{
    private Kwejk $kwejk;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->kwejk = self::$kernel->getContainer()->get(Kwejk::class);
    }

    public function testGetLinkToRandMem(): void
    {
        $this->assertIsString($this->kwejk->getLinkToRandMem());
    }
}
