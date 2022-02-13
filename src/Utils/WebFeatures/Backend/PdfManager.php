<?php

namespace App\Utils\WebFeatures\Backend;

use Knp\Snappy\Pdf;
use Symfony\Component\Filesystem\Filesystem;

class PdfManager
{
    private Filesystem $fileSystem;

    public function __construct(private Pdf $pdf)
    {
        $this->fileSystem = new Filesystem();
    }

    public function createPdf(string $view, string $path): void
    {
        if ($this->fileSystem->exists($path)) {
            $this->fileSystem->remove($path);
        }

        $this->pdf->generateFromHtml($view, $path, [
            'encoding' => 'utf-8',
        ]);
    }
}
