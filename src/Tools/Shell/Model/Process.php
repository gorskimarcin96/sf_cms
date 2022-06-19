<?php

namespace App\Tools\Shell\Model;

class Process
{
    public function __construct(
        private int $pid,
        private string $command,
        private string $tty,
        private string $stat,
        private string $time
    ) {
    }

    public function getPid(): int
    {
        return $this->pid;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getTty(): string
    {
        return $this->tty;
    }

    public function getStat(): string
    {
        return $this->stat;
    }

    public function getTime(): string
    {
        return $this->time;
    }
}
