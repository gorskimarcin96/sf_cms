<?php

namespace App\Utils\Counter;

use App\Entity\Counter;
use App\Repository\CounterRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class CounterManager
{
    public function __construct(private EntityManagerInterface $em, private CounterRepository $counterRepository)
    {
    }

    public function entry(string $url): void
    {
        $ip = $this->getIp();
        $counter = $this->counterRepository->findByIPAndDateAndUrl($ip, $url);
        $counter = $counter instanceof Counter
            ? $counter->setRefresh($counter->getRefresh() + 1)
            : $this->createCounter($ip, $url);

        $this->em->persist($counter);
        $this->em->flush();
    }

    private function getIp(): string
    {
        return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'anonym';
    }

    private function createCounter(string $ip, string $url): Counter
    {
        return (new Counter())
            ->setSessionId((string) session_id())
            ->setUrl($url)
            ->setIp($ip)
            ->setRefresh(1)
            ->setEntry(1)
            ->setDate(new \DateTime());
    }
}
