<?php

namespace App\Repository;

use App\Entity\YandexYmlOffer;
use App\Entity\YandexYmlShop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YandexYmlOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method YandexYmlOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method YandexYmlOffer[]    findAll()
 * @method YandexYmlOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YandexYmlOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YandexYmlOffer::class);
    }

    /**
     * @param YandexYmlShop $shop
     * @return YandexYmlOffer[]
     */
    public function getShopOffersByFlatId(YandexYmlShop $shop){
        $result = [];
        $qb = $this->createQueryBuilder('o');

        $qb
            ->where('o.shop = :shop')
            ->setParameters([
                'shop' => $shop
            ])
        ;
        /** @var YandexYmlOffer[] $offers */
        $offers = $qb->getQuery()->getResult();
        foreach ($offers as $offer){
            $result[$offer->getFlat()->getId()] = $offer;
        }

        return $result;
    }

    // /**
    //  * @return YandexYmlOffer[] Returns an array of YandexYmlOffer objects
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
    public function findOneBySomeField($value): ?YandexYmlOffer
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
