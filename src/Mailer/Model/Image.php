<?php

namespace App\Mailer\Model;

class Image
{
    public function __construct(private string $path, private string $filename)
    {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
