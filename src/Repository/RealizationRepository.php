<?php

namespace App\Repository;

use App\Entity\Realization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Realization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Realization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Realization[]    findAll()
 * @method Realization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realization::class);
    }

    public function findAllOrderByCreatedAtDesc(): array
    {
        return $this->findBy([], ['createdAt' => 'DESC']);
    }
}
