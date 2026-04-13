<?php

namespace App\Repository;

use App\Entity\BuildingProgressItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingProgressItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingProgressItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingProgressItem[]    findAll()
 * @method BuildingProgressItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingProgressItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingProgressItem::class);
    }

    // /**
    //  * @return BuildingProgressItem[] Returns an array of BuildingProgressItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuildingProgressItem
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
