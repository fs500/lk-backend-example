<?php

namespace App\Repository;

use App\Entity\SettingGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\UnexpectedResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SettingGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettingGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettingGroup[]    findAll()
 * @method SettingGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingGroup::class);
    }

    public function findByName($name){
        $qb = $this->createQueryBuilder('g')
            ->select('g, settings')
            ->leftJoin('g.settings', 'settings')
            ->where('g.name = :name')
            ->setParameters([
                'name' => $name
            ])
        ;

        $query = $qb->getQuery();
        try {
            $result = $query->getSingleResult();
        } catch (UnexpectedResultException $e) {
            $result = null;
        }

        return $result;
    }
}
