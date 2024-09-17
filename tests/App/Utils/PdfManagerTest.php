<?php

namespace App\Tests\App\Utils;

use App\Tests\Invoker;
use App\Utils\PdfManager;
use Knp\Snappy\Pdf;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class PdfManagerTest extends TestCase
{
    use Invoker;

    public function testCreatePdf(): void
    {
        $fileSystem = $this->createMock(Filesystem::class);
        $fileSystem->expects($this->once())
            ->method('exists')
            ->with('/path/to/file.pdf')
            ->willReturn(true);

        $fileSystem->expects($this->once())
            ->method('remove')
            ->with('/path/to/file.pdf');

        $pdf = $this->createMock(Pdf::class);
        $pdf->expects($this->once())
            ->method('generateFromHtml')
            ->with(
                '<html>Some HTML content</html>',
                '/path/to/file.pdf',
                [
                    'encoding' => 'utf-8',
                    'page-size' => 'A4',
                    'margin-top' => 12,
                    'margin-right' => 6,
                    'margin-bottom' => 12,
                    'margin-left' => 6,
                ]
            );

        $pdfManager = new PdfManager();
        $this->setPrivateProperty($pdfManager, 'pdf', $pdf);
        $this->setPrivateProperty($pdfManager, 'fileSystem', $fileSystem);
        $pdfManager->createPdf('<html>Some HTML content</html>', '/path/to/file.pdf');
    }
}
