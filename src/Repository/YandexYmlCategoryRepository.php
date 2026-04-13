<?php

namespace App\Repository;

use App\Entity\YandexYmlCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YandexYmlCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method YandexYmlCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method YandexYmlCategory[]    findAll()
 * @method YandexYmlCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YandexYmlCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YandexYmlCategory::class);
    }

    // /**
    //  * @return YandexYmlCategory[] Returns an array of YandexYmlCategory objects
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
    public function findOneBySomeField($value): ?YandexYmlCategory
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
