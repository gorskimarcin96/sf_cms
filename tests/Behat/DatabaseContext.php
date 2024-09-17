<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Entity\Counter;
use App\Entity\User;
use App\Repository\CounterRepository;
use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class DatabaseContext implements Context
{
    public function __construct(
        private CounterRepository $counterRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @Given the counter is clean
     */
    public function theCounterIsClean(): void
    {
        $this->counterRepository->truncate();
    }

    /**
     * @Given the refresh counter should be increased to :number for :page
     */
    public function theRefreshCounterShouldBeIncreasedTo(int $number, string $url): void
    {
        $this->entityManager->clear();

        Assert::assertSame($number, $this->counterRepository->findOneBy(['url' => $url])->getRefresh());
    }

    /**
     * @Given the entry counter should be increased to :number for :page
     */
    public function theEntryCounterShouldBeIncreasedTo(int $number, string $url): void
    {
        $this->entityManager->clear();

        Assert::assertSame($number, $this->counterRepository->findOneBy(['url' => $url])->getEntry());
    }

    /**
     * @Given the counter should be existed for :url
     */
    public function counterShouldBeExists(string $url): void
    {
        $this->entityManager->clear();

        Assert::assertSame(1, $this->counterRepository->count(['url' => $url]));
    }

    /**
     * @Given the counter should not be existed for :url
     */
    public function counterShouldNotBeExists(string $url): void
    {
        $this->entityManager->clear();

        Assert::assertSame(0, $this->counterRepository->count(['url' => $url]));
    }

    /**
     * @Given update email :email and password :password for main user
     */
    public function updateEmailAndPasswordForMainUser(string $email, string $password): void
    {
        $user = $this->userRepository->findOneBy([]);
        $user->setEmail($email)->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
