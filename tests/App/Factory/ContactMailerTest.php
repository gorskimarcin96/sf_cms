<?php

namespace App\Tests\App\Factory;

use App\Factory\ContactMailer;
use App\Tests\PHPUnitHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mime\Email;

class ContactMailerTest extends KernelTestCase
{
    use PHPUnitHelper;

    private ContactMailer $factory;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->factory = self::$kernel->getContainer()->get(ContactMailer::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }

    #[DataProvider('data')]
    public function testBuild(string $emailFrom, string $message): void
    {
        $email = $this->factory->build($emailFrom, $message);

        $this->assertInstanceOf(Email::class, $email);
        $this->assertSame($emailFrom, $email->getFrom()[0]->getAddress());
        $this->assertSame('example@test.com', $email->getTo()[0]->getAddress());
        $this->assertSame('Formularz kontaktowy mgorski.dev', $email->getSubject());
        $this->assertStringContainsString($message, $email->getHtmlBody());
    }

    /**
     * @return array<string[]>
     */
    public static function data(): array
    {
        return [
            ['fake@test', 'message'],
        ];
    }

}
