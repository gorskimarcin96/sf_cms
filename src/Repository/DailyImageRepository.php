<?php

namespace App\Repository;

use App\Entity\DailyImage;
use App\Repository\Traits\RandTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DailyImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyImage[]    findAll()
 * @method DailyImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method DailyImage|null randOne()
 * @method int[]           getIds(string $primaryKey = 'id')
 */
class DailyImageRepository extends ServiceEntityRepository
{
    use RandTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyImage::class);
    }
}
