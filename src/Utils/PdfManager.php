<?php

declare(strict_types=1);

namespace App\Utils;

use Knp\Snappy\Pdf;
use Symfony\Component\Filesystem\Filesystem;

class PdfManager
{
    private Pdf $pdf;

    private Filesystem $fileSystem;

    public function __construct()
    {
        $this->pdf = new Pdf($_ENV['WKHTMLTOPDF_PATH']);
        $this->fileSystem = new Filesystem();
    }

    public function createPdf(string $view, string $path): void
    {
        if ($this->fileSystem->exists($path)) {
            $this->fileSystem->remove($path);
        }

        $this->pdf->generateFromHtml($view, $path, [
            'encoding' => 'utf-8',
            'page-size' => 'A4',
            'margin-top' => 12,
            'margin-right' => 6,
            'margin-bottom' => 12,
            'margin-left' => 6,
        ]);
    }
}
