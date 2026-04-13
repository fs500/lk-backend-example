<?php

namespace App\Repository;

use App\Entity\PageSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageSlide|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageSlide|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageSlide[]    findAll()
 * @method PageSlide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageSliderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageSlide::class);
    }

    // /**
    //  * @return PageSlider[] Returns an array of PageSlider objects
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
    public function findOneBySomeField($value): ?PageSlider
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
