<?php

namespace App\Tests\Shell;

use App\Shell\Process;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProcessTest extends KernelTestCase
{
    private Process $process;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->process = self::$kernel->getContainer()->get(Process::class);
    }

    public function testRun(): void
    {
        $this->assertIsString($this->process->run('ps'));
    }

    public function testFind(): void
    {
        $this->assertNull($this->process->find(''));
    }

    public function testFinds(): void
    {
        $this->assertIsArray($this->process->finds('ps'));
    }
}
