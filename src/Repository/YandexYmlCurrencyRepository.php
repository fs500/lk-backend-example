<?php

namespace App\Repository;

use App\Entity\YandexYmlCurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YandexYmlCurrency|null find($id, $lockMode = null, $lockVersion = null)
 * @method YandexYmlCurrency|null findOneBy(array $criteria, array $orderBy = null)
 * @method YandexYmlCurrency[]    findAll()
 * @method YandexYmlCurrency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YandexYmlCurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YandexYmlCurrency::class);
    }

    // /**
    //  * @return YandexYmlCurrency[] Returns an array of YandexYmlCurrency objects
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
    public function findOneBySomeField($value): ?YandexYmlCurrency
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
