<?php

namespace App\Repository;

use App\Entity\Constant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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

    /** @throws EntityNotFoundException */
    public function findDropboxAuthorizationCode(): Constant
    {
        return $this->findOneBy(['title' => Constant::DROPBOX_AUTHORIZATION_CODE])
            ?? throw new EntityNotFoundException();
    }

    /** @throws EntityNotFoundException */
    public function findDropboxAccessToken(): Constant
    {
        return $this->findOneBy(['title' => Constant::DROPBOX_ACCESS_TOKEN]) ?? throw new EntityNotFoundException();
    }

    /** @throws EntityNotFoundException */
    public function findDropboxRefreshToken(): Constant
    {
        return $this->findOneBy(['title' => Constant::DROPBOX_REFRESH_TOKEN]) ?? throw new EntityNotFoundException();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Constant $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
