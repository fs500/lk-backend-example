<?php

namespace App\Services;

use App\Entity\Flat;
use App\Entity\YandexYmlCategory;
use App\Entity\YandexYmlCurrency;
use App\Entity\YandexYmlOffer;
use App\Entity\YandexYmlShop;
use App\Repository\FlatRepository;
use App\Repository\YandexYmlOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Eyetronic\YandexBuildingYml\Objects\Category;
use Eyetronic\YandexBuildingYml\Objects\Currency;
use Eyetronic\YandexBuildingYml\Objects\Offer;
use Eyetronic\YandexBuildingYml\Objects\Set;
use Eyetronic\YandexBuildingYml\Objects\Shop;
use Eyetronic\YandexBuildingYml\YmlGenerator;

class YandexYmlComposer
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FileUrlHelper
     */
    private $fileUrlHelper;

    /**
     * @var YmlGenerator
     */
    private $generator;

    public function __construct(EntityManagerInterface $em, FileUrlHelper $fileUrlHelper, YmlGenerator $generator){
        $this->em = $em;
        $this->fileUrlHelper = $fileUrlHelper;
        $this->generator = $generator;
    }

    public function xml(YandexYmlShop $shop){
        $this->generator->addShop($this->getShopObject($shop));
        $this->generator->addCurrencies($this->getCurrencyObjects());
        $this->generator->addCategories($this->getCategoryObjects($shop));
        $this->generator->addSets($this->getSetObjects($shop));
        $this->generator->addOffers($this->getOfferObjects($shop));

        return $this->generator->getXMLDocument();
    }

    /**
     * @param YandexYmlShop $shop
     * @return Shop
     */
    protected function getShopObject(YandexYmlShop $shop){
        $object = new Shop();
        $object
            ->setName($shop->getName())
            ->setUrl($shop->getUrl())
            ->setCompany($shop->getCompany())
            ->setEmail($shop->getEmail())
        ;

        return $object;
    }

    /**
     * @return Currency[]
     */
    protected function getCurrencyObjects(){
        $result = [];
        /** @var YandexYmlCurrency[] $entities */
        $entities = $this->em->getRepository(YandexYmlCurrency::class)->findAll();
        foreach ($entities as $entity){
            $object = new Currency();
            $object
                ->setId($entity->getName())
                ->setRate($entity->getRate())
            ;
            $result[] = $object;
        }

        return $result;
    }

    /**
     * @param YandexYmlShop $shop
     * @return Category[]
     */
    protected function getCategoryObjects(YandexYmlShop $shop){
        $result = [];
        foreach ($shop->getCategories() as $category){
            $object = new Category();
            $object
                ->setId($category->getId())
                ->setText($category->getHeader())
            ;
            if($category->getParent()){
                $object->setParentId($category->getParent()->getId());
            }
            $result[] = $object;
        }

        return $result;
    }

    /**
     * @param YandexYmlShop $shop
     * @return Set[]
     */
    protected function getSetObjects(YandexYmlShop $shop){
        $result = [];
        foreach ($shop->getSets() as $set){
            $object = new Set();
            $object
                ->setId($set->getId())
                ->setName($set->getName())
                ->setUrl($set->getUrl())
            ;
            $result[] = $object;
        }
        return $result;
    }

    protected function getOfferObjects(YandexYmlShop $shop){
        $result = [];
        $flats = $this->getFlats();
        $offers = $this->getOffersByFlatId($shop);
        $categories = [];
        foreach ($shop->getCategories() as $category){
            if(!is_null($category->getRoomsType())){
                $categories[$category->getRoomsType()] = $category;
            }
        }
        foreach ($flats as $flat){
            $result[] = $this->composeOffer($shop, $flat, $categories, isset($offers[$flat->getId()]) ? $offers[$flat->getId()] : null);
        }
        return $result;
    }

    /**
     * @return Flat[]
     */
    protected function getFlats(){
        /** @var FlatRepository $repository */
        $repository = $this->em->getRepository(Flat::class);
        return $repository->getFlatsYandexYml();
    }

    /**
     * @param YandexYmlShop $shop
     * @return YandexYmlOffer[]
     */
    protected function getOffersByFlatId(YandexYmlShop $shop){
        /** @var YandexYmlOfferRepository $repository */
        $repository = $this->em->getRepository(YandexYmlOffer::class);
        return $repository->getShopOffersByFlatId($shop);
    }

    /**
     * @param YandexYmlShop $shop
     * @param Flat $flat
     * @param YandexYmlCategory[] $categories
     * @param YandexYmlOffer|null $offer
     * @return Offer
     */
    protected function composeOffer(YandexYmlShop $shop, Flat $flat, array $categories, ?YandexYmlOffer $offer){
        $object = new Offer();

        $object
            ->setId($flat->getId())
            ->setName($this->getOfferName($flat, $offer))
            ->setVendor($shop->getVendor())
            ->setUrl($this->getOfferUrl($flat, $shop))
            ->setPrice($flat->getPrice())
            ->setCurrency($this->getOfferCurrency())
            ->setCategory($this->getOfferCategory($flat, $categories, $offer))
            ->setSets($this->getOfferSets($shop, $offer))
            ->setPictures($this->getOfferPictures($flat))
            ->setParamConversion($this->getOfferConversion($shop, $offer))
            ->setParamOfferType($shop->getParamOfferType())
            ->setDescription($this->getOfferDescription($shop, $offer))
            ->setParamBuilderUrl($shop->getParamBuilderUrl())
            ->setParamMinMortgage($shop->getParamMinMortgage())
            ->setParamEstateType($shop->getParamEstateType())
            ->setParamEstateClass($this->getOfferEstateClass($shop, $offer))
            ->setParamAddress($shop->getParamAddress())
            ->setParamLatitude($shop->getParamLatitude())
            ->setParamLongitude($shop->getParamLongitude())
            ->setParamBuiltYear($shop->getParamBuiltYear())
            ->setParamFloor($this->getOfferFlat($flat))
            ->setParamTotalFloor($shop->getParamTotalFloor())
            ->setParamRooms($this->getOfferRooms($flat))
            ->setParamFreePlan($offer ? $offer->getParamFreePlan() : null)
            ->setParamArea($flat->getArea())
            ->setParamSubwayDistance($shop->getParamSubwayDistance())
            ->setParamSubwayDistanceUnit($shop->getParamSubwayDistanceUnit())
            ->setParamParkingType($shop->getParamParkingType())
            ->setParamFinishing($this->getOfferFinishing($shop, $offer))
            ->setParamRepair($this->getOfferRepair($shop, $offer))
            ->setParamSite($shop->getParamSite())
            ->setParamPhone($shop->getParamPhone())
        ;
        return $object;
    }

    protected function getOfferName(Flat $flat, ?YandexYmlOffer $offer){
        if($offer && $offer->getName()){
            return $offer->getName();
        }
        else{
            switch ($flat->getRooms()){
                case Flat::ROOMS_STUDIO:
                    $name = "Студия";
                    break;
                default:
                    $name = $flat->getRooms() . "-комнатная";
                    break;
            }

            if($flat->getArea()){
                $name .= ", " . $flat->getArea() . " м²";
            }

            return $name;
        }
    }

    protected function getOfferUrl(Flat $flat){
        return "https://brownhouse.ru/apartment/" . $flat->getNumber();
    }

    /**
     * TODO криво сделано, надо использовать справочник из бд
     * @return Currency
     */
    protected function getOfferCurrency(){
        $result = new Currency();
        $result->setId(Currency::CURRENCY_ID_RUR)->setRate(1);
        return $result;
    }

    /**
     * @param Flat $flat
     * @param YandexYmlCategory[] $categories
     * @param YandexYmlOffer|null $offer
     * @return Category
     */
    protected function getOfferCategory(Flat $flat, array $categories, ?YandexYmlOffer $offer){
        $object = new Category();
        if($offer && $offer->getCategory()){
            $object
                ->setId($offer->getCategory()->getId())
                ->setText($offer->getCategory()->getHeader())
            ;
            if($offer->getCategory()->getParent()){
                $object->setParentId($offer->getCategory()->getParent()->getId());
            }
        }
        else{
            switch ($flat->getRooms()){
                case Flat::ROOMS_STUDIO:
                    if(isset($categories[Offer::PARAM_ROOMS_STUDIO])){
                        $object
                            ->setId($categories[Offer::PARAM_ROOMS_STUDIO]->getId())
                            ->setText($categories[Offer::PARAM_ROOMS_STUDIO]->getHeader())
                        ;
                    }
                    else{
                        $object
                            ->setId("s0")
                            ->setText("Студия")
                        ;
                    }
                    break;
                default:
                    if(isset($categories[$flat->getRooms()])){
                        $object
                            ->setId($categories[$flat->getRooms()]->getId())
                            ->setText($categories[$flat->getRooms()]->getHeader())
                        ;
                    }
                    else{
                        $object
                            ->setId("s" . $flat->getRooms())
                            ->setText($flat->getRooms() . "-комнатная")
                        ;
                    }
                    break;
            }
            $this->generator->addCategory($object);
        }

        return $object;
    }

    protected function getOfferSets(YandexYmlShop $shop, ?YandexYmlOffer $offer){
        $result = [];

        if($offer && $offer->getSets()){
            foreach ($offer->getSets() as $set){
                $object = new Set();
                $object
                    ->setId($set->getId())
                    ->setName($set->getName())
                    ->setUrl($set->getUrl())
                ;
                $this->generator->addSet($object);
                $result[] = $object;
            }
        }
        else{
            foreach ($shop->getSets() as $set){
                $object = new Set();
                $object
                    ->setId($set->getId())
                    ->setName($set->getName())
                    ->setUrl($set->getUrl())
                ;
                $this->generator->addSet($object);
                $result[] = $object;
            }
        }

        return $result;
    }

    protected function getOfferPictures(Flat $flat){
        $result = [];
        if($flat->getPlan()){
            $result[] = $this->fileUrlHelper->get($flat, 'planFile', $flat->getPlan());
        }
        if($flat->getPlan3d()){
            $result[] = $this->fileUrlHelper->get($flat, 'plan3dFile', $flat->getPlan3d());
        }
        return $result;
    }

    protected function getOfferConversion(YandexYmlShop $shop, ?YandexYmlOffer $offer){
        if(!is_null($offer) && $offer->getParamConversion()){
            return $offer->getParamConversion();
        }
        else{
            return $shop->getParamConversion();
        }
    }

    protected function getOfferDescription(YandexYmlShop $shop, ?YandexYmlOffer $offer){
        if(!is_null($offer) && $offer->getDescription()){
            return $offer->getDescription();
        }
        else{
            return $shop->getDescription();
        }
    }

    protected function getOfferEstateClass(YandexYmlShop $shop, ?YandexYmlOffer $offer){
        if(!is_null($offer) && $offer->getParamEstateClass()){
            return $offer->getParamEstateClass();
        }
        else{
            return $shop->getParamEstateClass();
        }
    }

    protected function getOfferFlat(Flat $flat){
        $result = null;
        if($flat->getFloor()){
            $result = $flat->getFloor()->getNumber();
        }
        return $result;
    }

    protected function getOfferRooms(Flat $flat){
        switch ($flat->getRooms()){
            case Flat::ROOMS_STUDIO:
                $result = Offer::PARAM_ROOMS_STUDIO;
                break;
            default:
                $result = $flat->getRooms();
            break;
        }

        return $result;
    }

    protected function getOfferFinishing(YandexYmlShop $shop, ?YandexYmlOffer $offer){
        if(!is_null($offer) && $offer->getParamFinishing()){
            return $offer->getParamFinishing();
        }
        else{
            return $shop->getParamFinishing();
        }
    }

    protected function getOfferRepair(YandexYmlShop $shop, ?YandexYmlOffer $offer){
        if(!is_null($offer) && $offer->getParamRepair()){
            return $offer->getParamRepair();
        }
        else{
            return $shop->getParamRepair();
        }
    }
}