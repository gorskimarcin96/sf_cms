<?php

namespace App\Tests\Tools\String;

use App\Tools\String\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testContainsTrue(): void
    {
        $validator = new Validator();

        $this->assertTrue($validator->contains('two', ['one', 'two', 'three']));
    }

    public function testContainsFalse(): void
    {
        $validator = new Validator();

        $this->assertFalse($validator->contains('zero', ['one', 'two', 'three']));
    }
}
