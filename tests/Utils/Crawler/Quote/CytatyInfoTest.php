<?php

namespace App\Tests\Utils\Crawler\Quote;

use App\Utils\Crawler\Quote\CytatyInfo;
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

    public function testGetQuote()
    {
        $this->assertIsString($this->cytatyInfo->getRandQuote());
    }
}
