<?php

namespace App\Repository;

use App\Entity\BuilderAdvantage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuilderAdvantage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuilderAdvantage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuilderAdvantage[]    findAll()
 * @method BuilderAdvantage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuilderAdvantageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuilderAdvantage::class);
    }

    // /**
    //  * @return BuilderAdvantage[] Returns an array of BuilderAdvantage objects
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
    public function findOneBySomeField($value): ?BuilderAdvantage
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
