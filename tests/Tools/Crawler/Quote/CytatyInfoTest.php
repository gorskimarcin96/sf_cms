<?php

namespace App\Tests\Tools\Crawler\Quote;

use App\Tools\Crawler\Quote\CytatyInfo;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CytatyInfoTest extends KernelTestCase
{
    private CytatyInfo $cytatyInfo;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->cytatyInfo = self::$kernel->getContainer()->get(CytatyInfo::class);
    }

    public function testGetQuote(): void
    {
        $this->assertIsString($this->cytatyInfo->getRandQuote());
    }
}
