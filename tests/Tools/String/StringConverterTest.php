<?php

namespace App\Tests\Tools\String;

use App\Tools\String\StringConverter;
use PHPUnit\Framework\TestCase;

class StringConverterTest extends TestCase
{
    public function testToString(): void
    {
        $stringConverter = new StringConverter('test string');

        $this->assertIsString($stringConverter->toString());
    }

    public function testTrim(): void
    {
        $stringConverter = new StringConverter('  test  ');

        $this->assertSame('test', $stringConverter->trim()->toString());
    }

    public function testRemoveMultilines(): void
    {
        $stringConverter = new StringConverter("test \r\n\r\n\r\n\r\n\r\nstring");

        $this->assertSame('test string', $stringConverter->removeMultilines()->toString());
    }

    public function testRemoveMultiSpaces(): void
    {
        $stringConverter = new StringConverter('test             string');

        $this->assertSame('test string', $stringConverter->removeMultiSpaces()->toString());
    }

    public function testRemoveHtmlTag(): void
    {
        $stringConverter = new StringConverter('test string<p>String in html p tag.</p>');

        $this->assertSame('test string', $stringConverter->removeHtmlTag('p')->toString());
    }

    public function testRemoveHtmlTagWithoutContent(): void
    {
        $stringConverter = new StringConverter('test string <p>String in html p tag.</p>');
        $value = $stringConverter->removeHtmlTag('p', false)->toString();

        $this->assertSame('test string String in html p tag.', $value);
    }

    public function testRemoveHtmlAttr(): void
    {
        $stringConverter = new StringConverter('<p style="color: red">test string</p>');

        $this->assertSame('<p>test string</p>', $stringConverter->removeHtmlAttr('style')->toString());
    }

    public function testRemoveString(): void
    {
        $stringConverter = new StringConverter('red green blue yellow black white');
        $value = $stringConverter->remove('black')->toString();

        $this->assertSame('red green blue yellow  white', $value);
    }

    public function testRemoveArrayStrings(): void
    {
        $stringConverter = new StringConverter('red green blue yellow black white');
        $value = $stringConverter->remove(['red', 'blue'])->toString();

        $this->assertSame(' green  yellow black white', $value);
    }

    public function testUcfirst(): void
    {
        $stringConverter = new StringConverter('żółć');

        $this->assertSame('Żółć', $stringConverter->ucfirst()->toString());
    }
}
