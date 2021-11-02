<?php

namespace App\Tests\Utils\Crawler\Mem;

use App\Utils\Crawler\Mem\Kwejk;
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

    public function testGetLinkToRandMem()
    {
        $this->assertIsString($this->kwejk->getLinkToRandMem());
    }
}
