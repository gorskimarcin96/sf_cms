<?php

namespace App\Tests\Utils\Mailer;

use App\Utils\Mailer\MailerFactory;
use App\Utils\Mailer\MailerWrongTypeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MailerFactoryTest extends KernelTestCase
{
    private MailerFactory $mailerFactory;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->mailerFactory = self::$kernel->getContainer()->get(MailerFactory::class);
    }

    public function testCreateTestMailerAddresses()
    {
        $emails = $this->mailerFactory->create('from@test.test', ['to@test.test'], MailerFactory::TEST_TYPE);

        $this->assertSame('from@test.test', $emails[0]->getFrom()[0]->getAddress());
        $this->assertSame('to@test.test', $emails[0]->getTo()[0]->getAddress());
    }

    public function testCreateTestMailerWrongType()
    {
        $this->expectException(MailerWrongTypeException::class);

        $this->mailerFactory->create('from@test.test', ['to@test.test'], 'wrongType');
    }

    public function testCreateTestMailerTypeTest()
    {
        $emails = $this->mailerFactory->create('from@test.test', ['to@test.test'], MailerFactory::TEST_TYPE);

        $this->assertSame('emails/test.html.twig', $emails[0]->getHtmlTemplate());
    }

    public function testCreateTestMailerTypeApelinia()
    {
        $emails = $this->mailerFactory->create('from@test.test', ['to@test.test'], MailerFactory::APELINIA_TYPE);

        $this->assertSame('emails/apelinia.html.twig', $emails[0]->getHtmlTemplate());
    }
}
