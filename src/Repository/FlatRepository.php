<?php

namespace App\Repository;

use App\Entity\Flat;
use App\Entity\FlatPrice;
use App\Entity\Form\FlatParameter;
use App\Entity\Form\Search\FlatSearch;
use App\Form\FlatParameterType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Flat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flat[]    findAll()
 * @method Flat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flat::class);
    }

    public function findBySearchForm(FlatSearch $search){
        $qb = $this->createQueryBuilder('f');

        if(!is_null($search->getNumber())){
            $qb
                ->andWhere('f.number = :number')
                ->setParameter('number', (int)$search->getNumber())
            ;
        }

        if(!empty($search->getFloor())){
            $qb
                ->leftJoin('f.floor', 'floor')
                ->andWhere('floor.number = :floor')
                ->setParameter('floor', $search->getFloor()->getNumber())
            ;
        }

        if(!empty($search->getStatus())){
            $qb
                ->andWhere('f.status = :status')
                ->setParameter('status', $search->getStatus())
            ;
        }

        if(!empty($search->getRooms())){
            $qb
                ->andWhere('f.rooms = :rooms')
                ->setParameter('rooms', $search->getRooms())
            ;
        }

        if(!empty($search->getPrice())){
            $qb
                ->andWhere('f.price = :price')
                ->setParameter('price', (int)$search->getPrice())
            ;
        }

        if(!empty($search->getPriceFinish())){
            $qb
                ->andWhere('f.priceFinish = :priceFinish')
                ->setParameter('priceFinish', (int)$search->getPriceFinish())
            ;
        }

        if(!empty($search->getPriceAction())){
            $qb
                ->andWhere('f.priceAction = :priceAction')
                ->setParameter('priceAction', (int)$search->getPriceAction())
            ;
        }

        if(!empty($search->getSort())){
            if(empty($search->getSortOrder()) || $search->getSortOrder() == FlatSearch::SORT_ORDER_ASC){
                $order = 'asc';
            }
            else{
                $order = 'desc';
            }
            $qb->orderBy('f.' . $search->getSort(), $order);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param FlatPrice $flatPrice
     * @return Flat[]
     */
    public function findFlatsByPrices(FlatPrice $flatPrice){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->leftJoin('f.floor', 'floor')
            ->andWhere('f.status IN (:statuses)')
            ->setParameter('statuses', [Flat::STATUS_CLOSED, Flat::STATUS_FREE])
        ;
        if($flatPrice->getRooms()){
            $qb
                ->andWhere('f.rooms IN (:rooms)')
                ->setParameter('rooms', $flatPrice->getRooms())
            ;
        }

        if($flatPrice->getFloors()){
            $qb
                ->andWhere('floor.number IN (:floors)')
                ->setParameter('floors', $flatPrice->getFloors())
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function getParameters(){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->select('MIN(f.price) as minPrice')
            ->addSelect('MAX(f.price) as maxPrice')
            ->addSelect('MIN(f.area) as minArea')
            ->addSelect('MAX(f.area) as maxArea')
            ->addSelect('MIN(floor.number) as minFloor')
            ->addSelect('MAX(floor.number) as maxFloor')
            ->leftJoin('f.floor', 'floor')
            ->andWhere('f.status IN(:status)')
            ->setParameters([
                'status' => [Flat::STATUS_FREE, Flat::STATUS_RESERVED]
            ])
        ;

        return $qb->getQuery()->getSingleResult();
    }

    public function getFlatsForWidget($limit = 4){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->select('f.rooms, MIN(f.price) mprice')
            ->groupBy('f.rooms')
            ->where('f.status = :status')
            ->setParameter('status', Flat::STATUS_FREE)
        ;
        $data = $qb->getQuery()->getResult();

        $rooms = [];
        $prices = [];
        foreach ($data as $d){
            $rooms[] = $d['rooms'];
            $prices[] = $d['mprice'];
        }

        $qb = $this->createQueryBuilder('f');
        $qb
            ->where('f.rooms IN (:rooms)')
            ->andWhere('f.price IN (:prices)')
            ->andWhere('f.status = :status')
            ->setParameters([
                'rooms' => $rooms,
                'prices' => $prices,
                'status' => Flat::STATUS_FREE,
            ])
            ->groupBy('f.rooms')
        ;
        $result = $qb->getQuery()->getResult();

        if(count($result) < $limit){
            $ids = [];
            foreach ($result as $r){
                $ids[] = $r->getId();
            }
            $qb = $this->createQueryBuilder('f');
            $qb
                ->where('f.status = :status')
                ->andWhere('f.id NOT IN (:ids)')
                ->addOrderBy('f.price')
                ->setMaxResults($limit - count($result))
                ->setParameters([
                    'status' => Flat::STATUS_FREE,
                    'ids' => $ids
                ])
            ;
            $result = array_merge($result, $qb->getQuery()->getResult());
        }

        usort($result,['App\Entity\Flat','sortByRooms']);

        return $result;
    }

    public function getMinMaxPrice(){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->select('MIN(f.price) as min')
            ->addSelect('MAX(f.price) as max')
        ;

        return $qb->getQuery()->getSingleResult();
    }

    public function getInSaleRoomsType(){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->select('f.rooms')
            ->distinct()
            ->andWhere('f.status IN(:status)')
            ->setParameters([
                'status' => [Flat::STATUS_FREE, Flat::STATUS_RESERVED]
            ])
        ;
        $result = $qb->getQuery()->getResult();
        if(isset($result['min'])){
            $result['min'] = (int)$result['min'];
        }
        if(isset($result['max'])){
            $result['max'] = (int)$result['max'];
        }
        return $result;
    }

    public function findAllBySearchForm(FlatParameter $form){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->leftJoin('f.floor', 'floor')
        ;
        if($form->getRooms()){
            $qb
                ->andWhere('f.rooms IN (:rooms)')
                ->setParameter('rooms', $form->getRooms())
            ;
        }
        if($form->getPriceMin()){
            $qb
                ->andWhere('f.price >= :minPrice')
                ->setParameter('minPrice', $form->getPriceMin())
            ;
        }
        if($form->getPriceMax()){
            $qb
                ->andWhere('f.price <= :maxPrice')
                ->setParameter('maxPrice', $form->getPriceMax())
            ;
        }
        if($form->getAreaMin()){
            $qb
                ->andWhere('f.area >= :minArea')
                ->setParameter('minArea', $form->getAreaMin())
            ;
        }
        if($form->getAreaMax()){
            $qb
                ->andWhere('f.area <= :maxArea')
                ->setParameter('maxArea', $form->getAreaMax())
            ;
        }
        if($form->getFloorMin()){
            $qb
                ->andWhere('floor.number >= :minFloor')
                ->setParameter('minFloor', $form->getFloorMin())
            ;
        }
        if($form->getFloorMax()){
            $qb
                ->andWhere('floor.number <= :maxFloor')
                ->setParameter('maxFloor', $form->getFloorMax())
            ;
        }
        if($form->getStatuses()){
            $qb
                ->andWhere('f.status IN (:statuses)')
                ->setParameter('statuses', $form->getStatuses())
            ;
        }

        $sortOrder = $form->getSortOrder() != FlatParameter::SORT_ORDER_DESC ? "ASC" : "DESC";
        switch ($form->getSortOrder()){
            default:
            case FlatParameter::SORT_FIELD_PRICE:
                $qb->addOrderBy('f.price', $sortOrder);
                break;
            case FlatParameter::SORT_FIELD_AREA:
                $qb->addOrderBy('f.area', $sortOrder);
                break;
            case FlatParameter::SORT_FIELD_FLOOR:
                $qb->addOrderBy('floor.number', $sortOrder);
                break;
            case FlatParameter::SORT_FIELD_ROOMS:
                $qb->addOrderBy('f.rooms', $sortOrder);
                break;
        }
        $qb->addOrderBy('f.number', $sortOrder);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * @return Flat[]
     */
    public function getFlatsYandexYml(){
        $qb = $this->createQueryBuilder('f');
        $qb
            ->leftJoin('f.floor', 'floor')
            ->andWhere('f.status IN(:status)')
            ->setParameters([
                'status' => [Flat::STATUS_FREE]
            ])
        ;

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
