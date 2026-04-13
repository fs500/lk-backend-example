<?php

namespace App\Repository;

use App\Entity\YandexYmlShop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YandexYmlShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method YandexYmlShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method YandexYmlShop[]    findAll()
 * @method YandexYmlShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YandexYmlShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YandexYmlShop::class);
    }

    // /**
    //  * @return YandexYmlShop[] Returns an array of YandexYmlShop objects
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
    public function findOneBySomeField($value): ?YandexYmlShop
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
