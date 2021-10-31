<?php

namespace App\Tests\Utils\File;

use App\Utils\File\LogReader;
use PHPUnit\Framework\TestCase;

class LogReaderTest extends TestCase
{
    private LogReader $logReader;

    protected function setUp(): void
    {
        parent::setUp();
        file_put_contents(__DIR__ . '/test.log', "test 1\r\ntest 2\r\ntest 3\r\ntest 4\r\ntest 5");

        $this->logReader = new LogReader(__DIR__ . '/test.log');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unlink(__DIR__ . '/test.log');
    }

    public function testGetCountLines()
    {
        $this->assertSame(5, $this->logReader->getCountLines());
    }

    public function testReadLogsAndStartLine()
    {
        $this->assertSame(["test 1\r\n", "test 2\r\n", "test 3\r\n", "test 4\r\n", "test 5"], $this->logReader->readLogs());
        $this->assertSame(1, $this->logReader->getStartLine());
    }

    public function testReadLogsWithArguments()
    {
        $this->assertSame(["test 2\r\n", "test 3\r\n"], $this->logReader->readLogs(1, 2));
        $this->assertSame(2, $this->logReader->getStartLine());
    }
}
