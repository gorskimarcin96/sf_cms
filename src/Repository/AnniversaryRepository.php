<?php

namespace App\Repository;

use App\Entity\Anniversary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Anniversary>
 *
 * @method Anniversary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anniversary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anniversary[]    findAll()
 * @method Anniversary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnniversaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anniversary::class);
    }

    public function add(Anniversary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Anniversary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
