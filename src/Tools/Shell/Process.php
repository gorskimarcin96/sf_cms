<?php

namespace App\Tools\Shell;

use App\Tools\String\StringConverter;
use Symfony\Component\Console\Output\BufferedOutput;

class Process
{
    public function run(string $command): string
    {
        $output = new BufferedOutput();
        $output->write(shell_exec($command));

        return $output->fetch();
    }

    public function find(string $searchCommand): ?\App\Tools\Shell\Model\Process
    {
        foreach ($this->finds($searchCommand) as $process) {
            if ($process->getCommand() === $searchCommand) {
                return $process;
            }
        }

        return null;
    }

    /** @return \App\Tools\Shell\Model\Process[] */
    public function finds(string $searchCommand = ''): array
    {
        $output = new BufferedOutput();
        $output->write(shell_exec($searchCommand !== "" ? sprintf('ps a | grep "%s"', $searchCommand) : 'ps a'));
        $response = $output->fetch();
        $lines = $response ? preg_split('/\n+/', trim($response)) : [];

        foreach ($lines as $line) {
            $outputToArray = explode(' ', (new StringConverter($line))->trim()->removeMultiSpaces());
            [$pid, $tty, $stat, $time] = $outputToArray;

            if ($pid === 'PID') {
                continue;
            }

            $command = implode(' ', array_diff($outputToArray, [$pid, $tty, $stat, $time]));
            $processes[] = new \App\Tools\Shell\Model\Process((int)$pid, $command, $tty, $stat, $time);
        }

        return $processes ?? [];
    }
}
