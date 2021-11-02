<?php

namespace App\Tests\Utils\String;

use App\Utils\String\StringConverter;
use PHPUnit\Framework\TestCase;

class StringConverterTest extends TestCase
{
    public function testGetString()
    {
        $stringConverter = new StringConverter('test string');
        
        $this->assertIsString($stringConverter->getString());
    }

    public function testRemoveMultilines()
    {
        $stringConverter = new StringConverter("test \r\n\r\n\r\n\r\n\r\nstring");

        $this->assertSame('test string', $stringConverter->removeMultilines()->getString());
    }

    public function testRemoveMultiSpaces()
    {
        $stringConverter = new StringConverter('test             string');

        $this->assertSame('test string', $stringConverter->removeMultiSpaces()->getString());
    }

    public function testRemoveScriptTag()
    {
        $stringConverter = new StringConverter('test string<script>console.log("test")</script>');

        $this->assertSame('test string', $stringConverter->removeScriptTag()->getString());
    }

    public function testRemoveHtmlTag()
    {
        $stringConverter = new StringConverter('test string<p>String in html p tag.</p>');

        $this->assertSame('test string', $stringConverter->removeHtmlTag('p')->getString());
    }
}
