<?php

namespace App\Tests\Tools\Mailer;

use App\Tools\Faker\Invoker;
use App\Tools\Mailer\ApeliniaMail;
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
