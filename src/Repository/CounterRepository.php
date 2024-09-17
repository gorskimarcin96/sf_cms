<?php

namespace App\Repository;

use App\Entity\Counter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Counter>
 *
 * @method Counter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Counter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Counter[]    findAll()
 * @method Counter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CounterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Counter::class);
    }

    /** @return int[][]|\DateTime[][] */
    public function getSumRefreshWithDateLastDays(int $days): array
    {
        return $this->queryBuilderChart($days)
            ->select('sum(d.refresh) AS value, d.date as date')
            ->getQuery()
            ->getResult();
    }

    /** @return int[][]|\DateTime[][] */
    public function getSumEntriesWithDateLastDays(int $days): array
    {
        return $this->queryBuilderChart($days)
            ->select('count(d.ip) AS value, d.date as date')
            ->getQuery()
            ->getResult();
    }

    private function queryBuilderChart(int $days): QueryBuilder
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('d')
            ->andWhere('d.date <= :dateFrom')
            ->andWhere('d.date >= :dateTo')
            ->setParameter('dateFrom', $now)
            ->setParameter('dateTo', (clone $now)->modify('-'.$days.' days'))
            ->groupBy('d.date')
            ->orderBy('d.date', 'DESC');
    }

    /** @throws NonUniqueResultException|NoResultException */
    public function sumRefreshForDays(int $days): bool|float|int|string
    {
        return $this->sumQueryBuilderForDays($days)
            ->select('sum(d.refresh)')
            ->getQuery()
            ->getSingleScalarResult() ?? 0;
    }

    public function sumEntriesForDays(int $days): int
    {
        $countIp = $this->sumQueryBuilderForDays($days)
            ->select('d.ip')
            ->groupBy('d.ip')
            ->getQuery()
            ->getResult();

        return is_countable($countIp) ? count($countIp) : 0;
    }

    private function sumQueryBuilderForDays(int $days): QueryBuilder
    {
        $now = new \DateTime();

        return $this->createQueryBuilder('d')
            ->andWhere('d.date <= :dateFrom')
            ->andWhere('d.date >= :dateTo')
            ->setParameter('dateFrom', $now)
            ->setParameter('dateTo', (clone $now)->modify('-'.$days.' days'));
    }

    public function truncate(): void
    {
        $this->createQueryBuilder('c')->delete()->getQuery()->getResult();
    }

    public function findByIPAndDateAndUrl(string $ip, string $url): ?Counter
    {
        return $this->findOneBy([
            'ip' => $ip,
            'url' => $url,
            'date' => new \DateTime(),
        ]);
    }
}
