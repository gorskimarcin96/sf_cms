<?php

namespace App\Utils\Features\Both\Counter;

use App\Entity\Counter;
use App\Repository\CounterRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class CounterManager
{
    public function __construct(private EntityManagerInterface $em, private CounterRepository $counterRepository)
    {
    }

    private function getIp(bool $ip2long = true)
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = 'anonym';
        }

        return $ip2long &&  $ip !== 'anonym' ? ip2long($ip) : $ip;
    }

    public function entry(): void
    {
        $ip = $this->getIp();
        $counter = $this->counterRepository->findOneBy(['ip' => $ip, 'date' => new DateTime()]);

        if (!$counter) {
            $counter = new Counter();
            $counter
                ->setSessionId(session_id())
                ->setIp($ip)
                ->setRefresh(1)
                ->setEntry(1)
                ->setDate(new DateTime());
        } else {
            $counter->setRefresh($counter->getRefresh() + 1);
        }

        $this->em->persist($counter);
        $this->em->flush();
    }
}
