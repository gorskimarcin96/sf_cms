<?php

namespace App\Command;

use App\DBAL\Types\LocaleType;
use App\Entity\DogJoke;
use App\Repository\DogJokeRepository;
use App\Tools\Crawler\Facebook\DogJokes;
use App\Tools\Crawler\Facebook\Exception\ImageNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:save-dog-jokes',
    description: 'Download dog jokes to database.',
)]
class SaveDogJokesCommand extends Command
{
    private const SLEEP_IMAGE_NOT_FOUND = 5;
    private const SLEEP_OTHER_EXCEPTION = 10;
    private const ERROR_LIMIT = 5;
    private int $i = 0;
    private int $errorNumber = 0;
    private ProgressBar $progressBar;

    public function __construct(
        private DogJokes               $dogJokes,
        private DogJokeRepository      $dogJokeRepository,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('login', InputArgument::REQUIRED, 'Login to facebook.')
            ->addArgument('password', InputArgument::REQUIRED, 'Password to facebook.')
            ->addArgument('locale', InputArgument::OPTIONAL, 'Country code to your profile.', LocaleType::ENGLISH);
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->progressBar = new ProgressBar($output);

        $this->dogJokes->createClient();
        $this->dogJokes->login(
            $input->getArgument('login'),
            $input->getArgument('password')
        );
        $this->dogJokes->setLocale($input->getArgument('locale'));

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
        } catch (ImageNotFoundException $exception) {
            $this->exceptionHandling($exception, $io, $output, self::SLEEP_IMAGE_NOT_FOUND, false);
        } catch (Exception $exception) {
            $this->exceptionHandling($exception, $io, $output, self::SLEEP_OTHER_EXCEPTION);
        }
    }

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

    private function exceptionHandling(Exception $exception, SymfonyStyle $io, OutputInterface $output, int $timeout, bool $incrementErrors = true): void
    {
        if ($incrementErrors) {
            $this->errorNumber++;
        }

        $io->newLine(2);
        $io->note(sprintf('Catch %s exception.', $exception::class));

        if ($this->errorNumber <= self::ERROR_LIMIT) {
            $io->note(sprintf('Timeout %s seconds.', $timeout));

            $progressBarSleep = new ProgressBar($output, $timeout);
            $progressBarSleep->start();
            for ($i = 0; $i < $timeout; $i++) {
                $progressBarSleep->advance();
                sleep(1);
            }
            $progressBarSleep->finish();
            $this->saveAll($io, $output);
        } else {
            $io->error('Too many errors.');
        }
    }
}
