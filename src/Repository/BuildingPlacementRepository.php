<?php

namespace App\Repository;

use App\Entity\BuildingPlacement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingPlacement|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingPlacement|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingPlacement[]    findAll()
 * @method BuildingPlacement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingPlacementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingPlacement::class);
    }

    // /**
    //  * @return BuildingPlacement[] Returns an array of BuildingPlacement objects
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
    public function findOneBySomeField($value): ?BuildingPlacement
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
