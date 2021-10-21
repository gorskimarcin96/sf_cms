<?php

namespace App\Tests\Utils\Encryption;

use App\Utils\Encryption\EncryptionManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EncryptionManagerTest extends KernelTestCase
{
    private EncryptionManager $encryptionManager;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->encryptionManager = self::$kernel->getContainer()->get(EncryptionManager::class);
    }

    public function testEncrypt()
    {
        $this->assertSame('m3Q1JehnC9N4WxLTgNGs5Q==', $this->encryptionManager->encrypt('test'));
    }

    public function testDecrypt()
    {
        $this->assertSame('test', $this->encryptionManager->decrypt('m3Q1JehnC9N4WxLTgNGs5Q=='));
    }
}
