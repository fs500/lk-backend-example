<?php


namespace App\Feed\Generator;


use App\Entity\Building;
use App\Entity\Contacts;
use App\Entity\Flat;
use App\Feed\View\GlavBaza\OfferNewFlatView;
use App\Feed\View\YaRealty\AreaView;
use App\Feed\View\YaRealty\LocationView;
use App\Feed\View\YaRealty\OfferNewFlatView as OfferNewFlatViewAlias;
use App\Feed\View\YaRealty\PriceView;
use App\Feed\View\YaRealty\SaleAgentView;
use DateTime;

class GlavBazaGenerator extends YaRealtyGenerator
{

    /**
     * @param Flat[] $offers
     * @param Contacts $contacts
     * @param Building $building
     * @param int $totalFloors
     * @return string
     */
    public function generate(
        $offers,
        $contacts,
        $building,
        $totalFloors
    ){
        $data = $this->getRootNode();
        foreach ($offers as $offer){
            $offerNode = $this->getOfferNode($offer, $contacts, $building, $totalFloors);
            $data['#']['offer'][] = [
                '@internal-id' => $offer->getNumber(),
                '#' => $offerNode
            ];
        }
        return $this->serializer->encode($data, 'xml');
    }

    protected function getOfferNode(Flat $flat, Contacts $contacts, Building $building, $totalFloors){
        $view = $this->getView();
        $date = new DateTime();

        $view
            ->setType(OfferNewFlatViewAlias::TYPE)
            ->setPropertyType(OfferNewFlatViewAlias::PROPERTY_TYPE)
            ->setCategory(OfferNewFlatViewAlias::CATEGORY_FLAT)
            ->setUrl($this->getFlatUrl($flat->getNumber()))
            ->setCreationDate($date->format('c'))
            ->setYandexHouseId(OfferNewFlatViewAlias::YANDEX_HOUSE_ID)
            ->setYandexBuildingId(OfferNewFlatViewAlias::YANDEX_BUILDING_ID)
            ->setLocation(new LocationView())
            ->getLocation()
            ->setCountry('Россия')
            ->setAddress($contacts->getObjectAddress())
            ->setLatitude($contacts->getObjectLatitude())
            ->setLongitude($contacts->getObjectLongitude())
        ;

        $view
            ->setSalesAgent(new SaleAgentView())
            ->getSalesAgent()
            ->setEmail($contacts->getEmail())
            ->setPhone($contacts->getPhone())
        ;
        $view
            ->setPrice(new PriceView())
            ->getPrice()
            ->setCurrency(PriceView::CURRENCY_RUR)
            ->setValue($flat->getPriceFinish() ?: $flat->getPrice())
        ;
        $view
            ->setArea(new AreaView())
            ->getArea()
            ->setUnit(AreaView::UNIT_DEFAULT)
            ->setValue($flat->getArea())
        ;
        $view
            ->setLivingSpace(new AreaView())
            ->getLivingSpace()
            ->setUnit(AreaView::UNIT_DEFAULT)
            ->setValue($flat->getRoomsArea())
        ;
        $view
            ->setKitchenSpace(new AreaView())
            ->getKitchenSpace()
            ->setUnit(AreaView::UNIT_DEFAULT)
            ->setValue($flat->getKitchenArea())
        ;

        $view
            ->setNewFlat(OfferNewFlatViewAlias::BOOL_TRUE)
            ->setFloor($flat->getFloor() ? $flat->getFloor()->getNumber() : null)
        ;
        if($flat->getRooms() != Flat::ROOMS_STUDIO){
            $view->setRooms($flat->getRooms());
        }
        else{
            $view->setStudio(OfferNewFlatViewAlias::BOOL_TRUE);
            $view->setRoomsType(OfferNewFlatView::ROOMS_TYPE_STUDIO);
        }

        $view
            ->setFloorsTotal($totalFloors)
            ->setBuiltYear($building->getDeadline())
            ->setReadyQuarter($building->getReadyQuarter())
            ->setBuildingName($building->getName())
        ;

        switch ($building->getBuildingState()){
            case Building::BUILDING_STATE_BUILT:
                $view->setBuildingState(OfferNewFlatViewAlias::BUILDING_STATE_BUILT);
                break;
            case Building::BUILDING_STATE_UNFINISHED:
                $view->setBuildingState(OfferNewFlatViewAlias::BUILDING_STATE_UNFINISHED);
                break;
            case Building::BUILDING_STATE_HAND_OVER:
                $view->setBuildingState(OfferNewFlatViewAlias::BUILDING_STATE_HAND_OVER);
                break;
        }

        switch ($building->getBuildingType()){
            case Building::BUILDING_TYPE_BRICK:
                $view->setBuildingType(OfferNewFlatViewAlias::BUILDING_TYPE_BRICK);
                break;
            case Building::BUILDING_TYPE_MONOLITH:
                $view->setBuildingType(OfferNewFlatViewAlias::BUILDING_TYPE_MONOLITH);
                break;
            case Building::BUILDING_TYPE_PANEL:
                $view->setBuildingType(OfferNewFlatViewAlias::BUILDING_TYPE_PANEL);
                break;
        }
        if($flat->getPriceFinish()){
            $view->setRenovation(OfferNewFlatViewAlias::RENOVATION_FINE);
        }
        else{
            switch ($building->getFinishType()){
                case Building::FINISH_TYPE_TURNKEY:
                    $view->setRenovation(OfferNewFlatViewAlias::RENOVATION_TURNKEY);
                    break;
                case Building::FINISH_TYPE_ROUGH:
                    $view->setRenovation(OfferNewFlatViewAlias::RENOVATION_ROUGH);
                    break;
                case Building::FINISH_TYPE_FINE:
                    $view->setRenovation(OfferNewFlatViewAlias::RENOVATION_FINE);
                    break;
            }
        }

        $result = $this->serializer->normalize($view);
        if($flat->getConvertedPlan()){
            $result['image'] = [];
            $result['image'][] = [
                '@tag' => 'plan',
                '#' => $this->fileUrlHelper->get($flat, 'convertedPlanFile', $flat->getConvertedPlan())
            ];
        }

        if($flat->getNumber()){
            $result['flat_num'] = $flat->getNumber();
        }

        $result['location']['metro'] = [];
        $result['location']['metro'][] = [
            'name' => 'Девяткино'
        ];

        return $result;
    }

    protected function getView()
    {
        return new OfferNewFlatView();
    }
}