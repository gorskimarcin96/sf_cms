<?php

namespace App\Repository\Traits;

trait RandTrait
{
    public function getIds($primaryKey = 'id'): array
    {
        $ids = $this->createQueryBuilder('p')
            ->select('p.id')
            ->getQuery()
            ->getResult();

        return array_map(static fn (array $id) => $id[$primaryKey], $ids);
    }

    public function randOne(): ?object
    {
        $ids = $this->getIds();

        if (!count($ids)) {
            return null;
        }

        $key = array_rand($ids);

        return $this->find($ids[$key]);
    }
}
