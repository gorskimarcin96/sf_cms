<?php

namespace App\Tests\Tools\Crawler\Quote;

use App\Tools\Crawler\Quote\Biblijni;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BiblijniTest extends KernelTestCase
{
    private Biblijni $biblijni;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->biblijni = self::$kernel->getContainer()->get(Biblijni::class);
    }

    public function testGetQuote(): void
    {
        $this->assertIsString($this->biblijni->getRandQuote());
    }
}
