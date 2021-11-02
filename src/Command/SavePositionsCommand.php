<?php

namespace App\Command;

use App\Entity\Position;
use App\Utils\Crawler\Ofeminin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:save-positions',
    description: 'Download kamasutra positions to database.',
)]
class SavePositionsCommand extends Command
{
    public function __construct(private Ofeminin $ofeminin, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $data = $this->ofeminin->getAll();
        $progressBar = new ProgressBar($output, $this->ofeminin->countUrls());

        $io->note('Waiting to download data.');
        $progressBar->start();

        foreach ($data as $datum) {
            $position = (new Position())
                ->setTitle($datum['title'])
                ->setImage($datum['image'])
                ->setFirstSection($datum['sections'][0])
                ->setSecondSection($datum['sections'][1]);

            $this->entityManager->persist($position);
            $progressBar->advance();
        }

        $this->entityManager->flush();
        $progressBar->finish();

        $io->newLine(2);
        $io->success('Positions is saved in database.');

        return Command::SUCCESS;
    }
}
