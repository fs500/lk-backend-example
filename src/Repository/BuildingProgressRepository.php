<?php

namespace App\Repository;

use App\Entity\BuildingProgress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\UnexpectedResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingProgress|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingProgress|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingProgress[]    findAll()
 * @method BuildingProgress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingProgress::class);
    }

    public function countDuplicatesByDate(BuildingProgress $entity){
        $qb = $this->createQueryBuilder('bp')
            ->select('COUNT(bp)')
            ->andWhere('DATE_FORMAT(bp.date, :format) = :date')
            ->setParameters([
                'date' => $entity->getDate()->format('Y-m'),
                'format' => "%Y-%m"
            ])
        ;
        if($entity->getId()){
            $qb
                ->andWhere('bp.id != :id')
               ->setParameter('id', $entity->getId())
            ;
        }

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (UnexpectedResultException $e) {
            return 0;
        }
    }
}
