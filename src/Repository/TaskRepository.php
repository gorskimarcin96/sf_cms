<?php

namespace App\Repository;

use App\Entity\Task;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function findAvailableTaskToExecute(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.executedAt <= :now')
            ->andWhere('t.isAdded = :isAdded')
            ->setParameters([
                'now'     => new DateTime(),
                'isAdded' => false,
            ])
            ->getQuery()
            ->getResult();
    }
}
