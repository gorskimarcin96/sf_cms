<?php

namespace App\Repository;

use App\Entity\TodoTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TodoTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoTask[]    findAll()
 * @method TodoTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoTask::class);
    }
}
