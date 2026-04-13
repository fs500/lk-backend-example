<?php

namespace App\Repository;

use App\Entity\PageCommerce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageCommerce|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageCommerce|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageCommerce[]    findAll()
 * @method PageCommerce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageCommerceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageCommerce::class);
    }

    // /**
    //  * @return PageCommerce[] Returns an array of PageCommerce objects
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
    public function findOneBySomeField($value): ?PageCommerce
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
