<?php

namespace App\Utils\File;

class FileManager
{
    public function __construct(private string $projectDir)
    {
    }

    public function getPathLogs(): array
    {
        $logDir = $this->projectDir . '/var/log';

        foreach (array_diff(scandir($logDir), ['.', '..']) as $fileName) {
            $files[] = $logDir . '/'. $fileName;
        }

        return $files ?? [];
    }
}
