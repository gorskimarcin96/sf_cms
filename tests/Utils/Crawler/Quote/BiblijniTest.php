<?php

namespace App\Tests\Utils\Crawler\Quote;

use App\Utils\Crawler\Quote\Biblijni;
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

    public function testGetQuote()
    {
        $this->assertIsString($this->biblijni->getRandQuote());
    }
}
