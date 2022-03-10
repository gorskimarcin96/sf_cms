<?php

namespace App\Tests\Mailer;

use App\Faker\Invoker;
use App\Mailer\ApeliniaMail;
use DateTime;
use SlopeIt\ClockMock\ClockMock;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApeliniaMailTest extends KernelTestCase
{
    use Invoker;

    private ApeliniaMail $apeliniaMail;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->apeliniaMail = self::$kernel->getContainer()->get(ApeliniaMail::class);
    }
    public function testCreate(): void
    {
        $this->assertInstanceOf(TemplatedEmail::class, $this->apeliniaMail->create());
    }
}
