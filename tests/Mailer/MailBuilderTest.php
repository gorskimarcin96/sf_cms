<?php

namespace App\Tests\Mailer;

use App\Mailer\MailBuilder;
use PHPUnit\Framework\TestCase;

class MailBuilderTest extends TestCase
{
    public function testBuildEmpty(): void
    {
        $builder = new MailBuilder();

        $this->assertSame('', $builder->renderHtml());
    }

    public function testBuildWithElements(): void
    {
        $builder = (new MailBuilder())
            ->append('<div>test1</div>')
            ->append('<div>test2</div>');

        $this->assertSame('<div>test1</div><div>test2</div>', $builder->renderHtml());
    }

    public function testBuildWithElementsAndLayout(): void
    {
        $builder = (new MailBuilder())
            ->setLayout('<body>{{ body }}</body>')
            ->append('<div>test1</div>')
            ->append('<div>test2</div>');

        $this->assertSame('<body><div>test1</div><div>test2</div></body>', $builder->renderHtml());
    }
}
