<?php

namespace App\Repository;

use App\Entity\YandexYmlSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YandexYmlSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method YandexYmlSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method YandexYmlSet[]    findAll()
 * @method YandexYmlSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YandexYmlSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YandexYmlSet::class);
    }

    // /**
    //  * @return YandexYmlSet[] Returns an array of YandexYmlSet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?YandexYmlSet
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
