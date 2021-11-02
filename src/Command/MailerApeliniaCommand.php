<?php

namespace App\Command;

use App\Message\Mailer;
use App\Utils\Mailer\MailerFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:mailer:apelinia',
    description: 'Adding mailer "' . MailerFactory::APELINIA_TYPE . '" to queue.',
)]
class MailerApeliniaCommand extends Command
{
    public function __construct(private MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('from', InputArgument::REQUIRED, 'Email from send')
            ->addArgument('to', InputArgument::REQUIRED, 'Email to send');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $mailer = new Mailer($input->getArgument('from'), [$input->getArgument('to')], MailerFactory::APELINIA_TYPE);
        $this->messageBus->dispatch($mailer);

        $io->success(sprintf('Added mailer "%s" to queue.', MailerFactory::APELINIA_TYPE));

        return Command::SUCCESS;
    }
}
