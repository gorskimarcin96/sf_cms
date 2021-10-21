<?php

namespace App\Utils\Features;

use App\Entity\Counter;
use App\Repository\CounterRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class CounterService
{
    private const DAYS = [30, 3 * 30, 6 * 30, 12 * 30, 10 * 12 * 30];
    private const TIME = 3600;

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

        return $ip2long ? ip2long($ip) : $ip;
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

    public function getChartData(): array
    {
        $cache = new FilesystemAdapter();

        return $cache->get('counter.chart_data', function (ItemInterface $item) {
            $item->expiresAfter(self::TIME);

            foreach (self::DAYS as $day) {
                $dataToCharts[] = [
                    'days' => $day,
                    'refresh' => $this->counterRepository->getRefreshForChart($day),
                    'entries' => $this->counterRepository->getEntriesForChart($day),
                ];
            }

            foreach ($dataToCharts as $chartNumber => $datumToChart) {
                foreach ($datumToChart as $nameChart => $data) {
                    if (is_array($data)) {
                        foreach ($data as $key => $datum) {
                            $dataToCharts[$chartNumber][$nameChart][$key]['x'] = $datum['x']->format('Y-m-d');
                        }
                    }
                }
            }

            return $dataToCharts;
        });
    }

    public function getStatistics(): array
    {
        $cache = new FilesystemAdapter();

        return $cache->get('counter.statistics', function (ItemInterface $item) {
            $item->expiresAfter(self::TIME);

            foreach (self::DAYS as $day) {
                $data[] = [
                    'days' => $day,
                    'refresh' => $this->counterRepository->sumRefreshForDays($day),
                    'entries' => $this->counterRepository->sumEntriesForDays($day),
                ];
            }

            return $data;
        });
    }
}
