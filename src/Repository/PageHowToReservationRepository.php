<?php

namespace App\Repository;

use App\Entity\PageHowToReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageHowToReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageHowToReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageHowToReservation[]    findAll()
 * @method PageHowToReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageHowToReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageHowToReservation::class);
    }

    // /**
    //  * @return PageHowToReservation[] Returns an array of PageHowToReservation objects
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
    public function findOneBySomeField($value): ?PageHowToReservation
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
