<?php

namespace App\Command;

use App\Crawler\Facebook\DogJokes;
use App\Entity\DogJoke;
use App\Repository\DogJokeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Facebook\WebDriver\Exception\StaleElementReferenceException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\Exception\WebDriverCurlException;
use Facebook\WebDriver\Exception\WebDriverException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:save-dog-jokes',
    description: 'Download dog jokes to database.',
)]
class SaveDogJokesCommand extends Command
{
    private const SLEEP = 30;
    private int $i = 0;
    private ProgressBar $progressBar;

    public function __construct(private DogJokes $dogJokes, private DogJokeRepository $dogJokeRepository, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->progressBar = new ProgressBar($output);

        $io->note('Waiting to download data.');
        $this->progressBar->start();
        $this->saveAll($io, $output);
        $this->progressBar->finish();

        $io->newLine(2);
        $io->success(sprintf('Dog jokes(%s) is saved in database.', $this->i));

        return Command::SUCCESS;
    }

    private function saveAll(SymfonyStyle $io, OutputInterface $output): void
    {
        try {
            $this->save();
        } catch (StaleElementReferenceException|WebDriverCurlException|TimeoutException $exception) {
            $io->newLine(2);
            $io->note(sprintf('Catch %s exception.', $exception::class));
            $io->note(sprintf('Timeout %s seconds.', self::SLEEP));

            $progressBarSleep = new ProgressBar($output, self::SLEEP);
            $progressBarSleep->start();
            for ($i = 0; $i < self::SLEEP; $i++) {
                $progressBarSleep->advance();
                sleep(1);
            }
            $progressBarSleep->finish();
            $this->saveAll($io, $output);
        }
    }

    /**
     * @throws WebDriverException
     * @throws TimeoutException
     */
    private function save(): void
    {
        $lastDogJoke = $this->dogJokeRepository->findLast();

        foreach ($this->dogJokes->getAll($lastDogJoke?->getUrl()) as $datum) {
            if ($datum === null || $this->dogJokeRepository->findOneByUrl($datum['url']) instanceof DogJoke) {
                continue;
            }

            [$width, $height] = getimagesize($datum['image']);

            $dogJoke = (new DogJoke())
                ->setUrl($datum['url'])
                ->setImage($datum['image'])
                ->setWidth($width)
                ->setHeight($height);

            $this->entityManager->persist($dogJoke);
            $this->entityManager->flush();
            $this->progressBar->advance();
            $this->i++;
        }
    }
}
