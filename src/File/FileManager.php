<?php

namespace App\File;

class FileManager
{
    public function __construct(private string $projectDir)
    {
    }

    public function saveFile(string $file, ?string $name = null, bool $isPrivateDir = false)
    {
        file_put_contents($this->getDir($isPrivateDir) . ($name ?: (time() . '.jpg')), $file);
    }

    /** @return resource */
    public function openFile(string $fileName, bool $isPrivateDir = false)
    {
        return fopen($this->getDir($isPrivateDir) . $fileName, 'r');
    }

    private function getDir(bool $isPrivateDir): string
    {
        return $this->projectDir . '/' . ($isPrivateDir ? 'private' : 'public') . '/';
    }
}
