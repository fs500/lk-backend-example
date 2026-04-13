<?php

namespace App\Repository;

use App\Entity\PageInfrastructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageInfrastructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageInfrastructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageInfrastructure[]    findAll()
 * @method PageInfrastructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageInfrastructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageInfrastructure::class);
    }

    // /**
    //  * @return PageInfrastructure[] Returns an array of PageInfrastructure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PageInfrastructure
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
