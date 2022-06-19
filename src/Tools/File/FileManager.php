<?php

namespace App\Tools\File;

class FileManager
{
    public function __construct(private string $projectDir)
    {
    }

    public function saveFile(string $file, ?string $fileName = null, bool $isPrivateDir = false): void
    {
        file_put_contents($this->getPath($fileName ?: (time() . '.jpg'), $isPrivateDir), $file);
    }

    public function getPath(string $fileName, bool $isPrivateDir): string
    {
        return $this->getDir($isPrivateDir) . $fileName;
    }

    /** @return resource */
    public function openFile(string $fileName, bool $isPrivateDir = false)
    {
        return fopen($this->getPath($fileName, $isPrivateDir), 'r');
    }

    private function getDir(bool $isPrivateDir): string
    {
        return $this->projectDir . '/' . ($isPrivateDir ? 'private' : 'public') . '/';
    }
}
