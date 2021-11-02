<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    public function getIds(): array
    {
        $ids = $this->createQueryBuilder('p')
            ->select('p.id')
            ->getQuery()
            ->getResult();

        foreach ($ids as $id) {
            $data[] = $id['id'];
        }

        return $data ?? [];
    }

    public function randOne(): ?Position
    {
        $ids = $this->getIds();

        if (!count($ids)) {
            return null;
        }

        $key = array_rand($ids);

        return $this->find($ids[$key]);
    }
}
