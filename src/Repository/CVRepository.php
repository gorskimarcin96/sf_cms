<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CV;
use App\Enum\CVEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CV>
 *
 * @method CV|null find($id, $lockMode = null, $lockVersion = null)
 * @method CV|null findOneBy(array $criteria, array $orderBy = null)
 * @method CV[]    findAll()
 * @method CV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CV::class);
    }

    public function findByEnum(CVEnum $CVEnum): CV
    {
        return $this->findOneBy(['type' => $CVEnum]) ?? throw new EntityNotFoundException('CV is not found.');
    }

    public function updateConstantDescriptionByEnum(string $data, CVEnum $CVEnum): void
    {
        $this->createQueryBuilder('cv')
            ->set('cv.description', $data)
            ->where('cv.type = :type')
            ->setParameter('type', $CVEnum)
            ->getQuery()
            ->execute();
    }
}
