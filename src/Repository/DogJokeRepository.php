<?php

namespace App\Repository;

use App\Entity\DogJoke;
use App\Repository\Traits\RandTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DogJoke|null find($id, $lockMode = null, $lockVersion = null)
 * @method DogJoke|null findOneBy(array $criteria, array $orderBy = null)
 * @method DogJoke[]    findAll()
 * @method DogJoke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method DogJoke|null randOne()
 * @method int[]        getIds(string $primaryKey = 'id')
 */
class DogJokeRepository extends ServiceEntityRepository
{
    use RandTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DogJoke::class);
    }

    public function findLast(): ?DogJoke
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.createdAt', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByUrl(string $url): ?DogJoke
    {
        return $this->findOneBy(['url' => $url]);
    }
}
