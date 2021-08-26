<?php

namespace App\Repository;

use App\Entity\Constant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Constant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Constant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Constant[]    findAll()
 * @method Constant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constant::class);
    }

    public function findCV(): Constant
    {
        return $this->findOneBy(['title' => Constant::CV]);
    }

    public function findCVDraft(): Constant
    {
        return $this->findOneBy(['title' => Constant::CV_DRAFT]);
    }

    public function updateConstantDescriptionByTitle(string $title, string $description): void
    {
        $constant = $this->findOneBy(['title' => $title]);
        $constant->setDescription($description);

        $this->getEntityManager()->persist($constant);
        $this->getEntityManager()->flush();
    }
}
