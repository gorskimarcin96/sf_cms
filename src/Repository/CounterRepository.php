<?php

namespace App\Repository;

use App\Entity\Counter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    public function getRefreshForChart(int $days)
    {
        return $this->queryBuilderChart($days)
            ->select('sum(d.refresh) AS y, d.date as x')
            ->getQuery()
            ->getResult();
    }

    public function getEntriesForChart(int $days)
    {
        return $this->queryBuilderChart($days)
            ->select('count(d.ip) AS y, d.date as x')
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

    public function sumRefreshForDays(int $days): int
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

        return count($countIp);
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
}
