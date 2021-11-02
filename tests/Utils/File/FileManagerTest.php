<?php

namespace App\Tests\Utils\File;

use App\Tests\Invoker;
use App\Utils\File\FileManager;
use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    private FileManager $fileManager;

    use Invoker;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['/var/log', '/public', '/private'] as $dir) {
            shell_exec('mkdir -p ' . __dir__ . $dir);
        }
        file_put_contents(__DIR__ . '/public/test.img', '');
        file_put_contents(__DIR__ . '/var/log/test.log', '');

        $this->fileManager = new FileManager(__DIR__);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        foreach (['/var', '/public', '/private'] as $dir) {
            shell_exec('rm -rf ' . __dir__ . $dir);
        }
    }

    public function testGetPathLogs()
    {
        $this->assertSame(['/var/www/html/tests/Utils/File/var/log/test.log'], $this->fileManager->getPathLogs());
    }

    public function testSaveFile()
    {
        $this->fileManager->saveFile('http://localhost/build/img/mgorski.png', 'mgorski.png',);
        $this->assertTrue(file_exists(__DIR__ . '/public/mgorski.png'));
    }


    public function testOpenFilePrivate()
    {
        $this->assertIsResource($this->fileManager->openFile('test.img'));
    }

    public function testOpenFilePublic()
    {
        $this->assertIsResource($this->fileManager->openFile('test.img'));
    }

    public function testGetDirPrivate()
    {
        $this->assertSame(
            '/var/www/html/tests/Utils/File/private/',
            $this->invokeMethod($this->fileManager, 'getDir', [true])
        );
    }

    public function testGetDirPublic()
    {
        $this->assertSame(
            '/var/www/html/tests/Utils/File/public/',
            $this->invokeMethod($this->fileManager, 'getDir', [false])
        );
    }
}
