<?php

namespace App\Repository;

use App\Entity\TodoList;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TodoList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoList[]    findAll()
 * @method TodoList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoList::class);
    }

    public function findByUserAccessAndNotIsDone(User $user)
    {
        return $this->createQueryBuilder('t')
            ->join('t.userAccess', 'u')
            ->andWhere('t.isDone = :isDone')
            ->andWhere('u.id = :user')
            ->setParameters(['user' => $user, 'isDone' => false])
            ->getQuery()
            ->getResult();
    }
}
