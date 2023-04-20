<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function findBySearch(string $name = null, string $family = null, int $page = 1, int $limit = 10)
    {
        $qb = $this->createQueryBuilder('f');

        if ($name) {
            $qb->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if ($family) {
            $qb->andWhere('f.family LIKE :family')
                ->setParameter('family', '%' . $family . '%');
        }

        $qb->orderBy('f.id', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function countBySearch(string $name = null, string $family = null)
    {
        $qb = $this->createQueryBuilder('f');

        $qb->select('COUNT(f.id)');
        if ($name) {
            $qb->andWhere('f.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if ($family) {
            $qb->andWhere('f.family LIKE :family')
                ->setParameter('family', '%' . $family . '%');
        }


        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findFavorites()
    {
        return $this->createQueryBuilder('f')
            ->where('f.favorite = :favorite')
            ->setParameter('favorite', true)
            ->getQuery()
            ->getResult();
    }
}
