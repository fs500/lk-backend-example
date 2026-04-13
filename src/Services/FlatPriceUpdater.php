<?php


namespace App\Services;


use App\Entity\Flat;
use App\Entity\FlatPrice;
use App\Repository\FlatPriceRepository;
use App\Repository\FlatRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class FlatPriceUpdater
{
    /**
     * @var FlatPriceRepository
     */
    private $flatPriceRepository;

    /**
     * @var FlatRepository
     */
    private $flatRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        FlatRepository $flatRepository,
        FlatPriceRepository $flatPriceRepository,
        EntityManagerInterface $em
    ){
        $this->flatRepository = $flatRepository;
        $this->flatPriceRepository = $flatPriceRepository;
        $this->em = $em;
    }

    public function update(){
        $date = new DateTime();
        $prices = $this->flatPriceRepository->findAll();
        foreach ($prices as $price){
            $price->setDate(clone $date);
            $flats = $this->flatRepository->findFlatsByPrices($price);
            foreach ($flats as $flat){
                $this->calculatePrice($price, $flat);
            }
        }
        $this->em->flush();
        return $date;
    }

    protected function calculatePrice(FlatPrice $flatPrice, Flat $flat){
        if($flatPrice->getPrice()){
            $flat
                ->setPriceM($flatPrice->getPrice())
                ->setPrice($flatPrice->getPrice() * $flat->getArea())
            ;
        }
    }
}