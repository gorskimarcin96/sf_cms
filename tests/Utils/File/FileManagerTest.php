<?php

namespace App\Tests\Utils\File;

use App\Utils\File\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    public function testGetPathLogs()
    {
        $fileManager = new FileManager(__DIR__);
        mkdir(__DIR__ . '/var');
        mkdir(__DIR__ . '/var/log');
        file_put_contents(__DIR__ . '/var/log/test.log', '');

        $this->assertSame('/var/www/html/tests/Utils/File/var/log/test.log', $fileManager->getPathLogs()[0]);

        unlink(__DIR__ . '/var/log/test.log');
        rmdir(__DIR__ . '/var/log');
        rmdir(__DIR__ . '/var');
    }
}
