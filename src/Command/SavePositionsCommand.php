<?php

namespace App\Command;

use App\DBAL\Types\PositionType;
use App\Entity\Position;
use App\Repository\PositionRepository;
use App\Tools\Crawler\Camasutra\CamasutraInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:save-positions',
    description: 'Download camasutra positions to database.',
)]
class SavePositionsCommand extends Command
{
    public function __construct(
        private iterable $camasutraServices,
        private PositionRepository $positionRepository,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('class', 'c', InputArgument::OPTIONAL, 'Select class to download data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $added = 0;

        foreach ($this->camasutraServices as $service) {
            if ($input->getOption('class') !== null && $input->getOption('class') !== get_class($service)) {
                continue;
            }

            $positionType = PositionType::getKey($service::class);
            $io->newLine(2);

            /** @var CamasutraInterface $service */
            $progressBar = $service->isCountable()
                ? new ProgressBar($output, $service->countUrls())
                : new ProgressBar($output);

            $io->note("Waiting to download data from ".get_class($service).".");
            $progressBar->start();

            foreach ($service->getAll() as $datum) {
                if (null === $this->positionRepository->findOneByTitleAndType($datum['title'], $positionType)) {
                    $position = (new Position())
                        ->setTitle($datum['title'])
                        ->setImage($datum['image'])
                        ->setFirstSection($datum['sections'][0])
                        ->setSecondSection($datum['sections'][1])
                        ->setPositionType($positionType);

                    $this->entityManager->persist($position);
                    $this->entityManager->flush();

                    $added++;
                }
                $progressBar->advance();
            }

            $progressBar->finish();
        }

        $io->newLine(2);
        $io->success(sprintf("Added new %s positions.", $added));

        return Command::SUCCESS;
    }
}
