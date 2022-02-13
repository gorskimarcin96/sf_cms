<?php

namespace App\Tests\Utils\WebFeatures\Backend;

use App\Utils\WebFeatures\Backend\PdfManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PdfManagerTest extends KernelTestCase
{
    private PdfManager $pdfManager;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->pdfManager = self::$kernel->getContainer()->get(PdfManager::class);
    }

    public function testCreatePdf()
    {
        $pathPdf = __dir__ . '/test.pdf';

        $this->pdfManager->createPdf('test', $pathPdf);
        $this->assertTrue(file_exists($pathPdf));
        unlink($pathPdf);
    }
}
