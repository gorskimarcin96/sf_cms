<?php

namespace App\Repository;

use App\Entity\DogJoke;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DogJoke|null find($id, $lockMode = null, $lockVersion = null)
 * @method DogJoke|null findOneBy(array $criteria, array $orderBy = null)
 * @method DogJoke[]    findAll()
 * @method DogJoke[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DogJokeRepository extends ServiceEntityRepository
{
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

    public function randSixNormal(): array
    {
        return [
            $this->randNormal(), $this->randNormal(), $this->randNormal(),
            $this->randNormal(), $this->randNormal(), $this->randNormal(),
        ];
    }

    public function randToCollage(): array
    {
        return [
            $this->randWidth(),
            $this->randHeight(),
            $this->randNormal(),
            $this->randNormal(),
        ];
    }

    public function randNormal(): ?DogJoke
    {
        return $this->rand($this->getNormalImageIds());
    }

    public function randWidth(): ?DogJoke
    {
        return $this->rand($this->getWidthImageIds());
    }

    public function randHeight(): ?DogJoke
    {
        return $this->rand($this->getHeightImageIds());
    }

    private function getNormalImageIds(): array
    {
        $ids = $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.height < 1.5 * p.width')
            ->andWhere('p.width < 1.5 * p.height')
            ->getQuery()
            ->getResult();

        return array_map(static fn (array $id) => $id['id'], $ids);
    }

    private function getWidthImageIds(): array
    {
        $ids = $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.width >= (p.height * 1.5)')
            ->getQuery()
            ->getResult();

        return array_map(static fn (array $id) => $id['id'], $ids);
    }

    private function getHeightImageIds(): array
    {
        $ids = $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.height >= (p.width * 1.5)')
            ->getQuery()
            ->getResult();

        return array_map(static fn (array $id) => $id['id'], $ids);
    }

    private function rand(array $ids): ?DogJoke
    {
        if (!count($ids)) {
            return null;
        }

        return $this->find($ids[array_rand($ids)]);
    }
}
