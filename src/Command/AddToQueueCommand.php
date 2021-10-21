<?php

namespace App\Command;

use App\Utils\Task\TaskManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:task:add-to-queue',
    description: 'Command added tasks to queue.',
)]
class AddToQueueCommand extends Command
{
    public function __construct(private TaskManager $taskManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $taskAddedNumber = $this->taskManager->addAvailableTasksToQueue();

        $io->success(sprintf('Added %s tasks to queue', $taskAddedNumber));

        return Command::SUCCESS;
    }
}
