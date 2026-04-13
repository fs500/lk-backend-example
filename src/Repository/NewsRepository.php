<?php

namespace App\Repository;

use App\Entity\Form\NewsList;
use App\Entity\Form\NewsSingle;
use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\UnexpectedResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function getList(NewsList $newsList){
        $qb = $this->createQueryBuilder('n');

        $qb
            ->orderBy('n.date', 'desc')
            ->setMaxResults($newsList->getLimit())
            ->setFirstResult($newsList->getOffset())
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $limit
     * @param News|null $exceptNews
     * @return News[]
     */
    public function findNewest($limit = 3, $exceptNews = null){
        $qb = $this->createQueryBuilder('n');
        $qb
            ->orderBy('n.date', 'desc')
            ->setMaxResults($limit)
        ;
        if(!is_null($exceptNews)){
            $qb
                ->where('n.id != :id')
                ->setParameter('id', $exceptNews->getId())
            ;
        }

        return $qb->getQuery()->getResult();
    }

}
