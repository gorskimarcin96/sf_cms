<?php

namespace App\Command;

use App\Tools\Shell\Process;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:queue:run', description: 'Queue runner.',)]
class RunQueueCommand extends Command
{
    public function __construct(private Process $process)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('queueType', InputArgument::OPTIONAL, 'Queue type.', 'async');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('queueType');

        $search = false;
        foreach ($this->process->finds('php') as $process) {
            if (str_contains($process->getCommand(), 'messenger:consume '.$type)) {
                $search = true;

                break;
            }
        }

        if ($search === false) {
            $this->process->run('./bin/console messenger:consume '.$type);
        }

        return Command::SUCCESS;
    }
}
