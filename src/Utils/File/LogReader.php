<?php

namespace App\Utils\File;

class LogReader
{
    public const LINE_DIFFERENCE = 10;

    private array|false $data;
    private int $sizeFile;
    private int $startLine;

    public function __construct(string $pathToFile)
    {
        $this->data = file($pathToFile);
        $this->sizeFile = count($this->data);
    }

    public function getCountLines(): int
    {
        return $this->sizeFile;
    }

    public function getStartLine(): int
    {
        return $this->startLine;
    }

    public function readLogs(?int $from = null, ?int $to = null): array
    {
        $from = !($from === null) ? $from : ($this->sizeFile - self::LINE_DIFFERENCE > 0 ? $this->sizeFile - self::LINE_DIFFERENCE : 0);
        $to = !($to === null) ? $to : $this->sizeFile;

        $this->startLine = $from > 0 ? $from + 1 : 1;

        foreach (range($from, $to) as $line) {
            if (isset($this->data[$line])) {
                $data[] = $this->data[$line];
            }
        }

        return $data ?? [];
    }
}
