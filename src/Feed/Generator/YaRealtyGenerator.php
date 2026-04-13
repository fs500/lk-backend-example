<?php


namespace App\Feed\Generator;


use App\Entity\Building;
use App\Entity\Contacts;
use App\Entity\Flat;
use App\Feed\Converter\CamelCaseToChainCaseNameConverter;
use App\Feed\View\YaRealty\AreaView;
use App\Feed\View\YaRealty\LocationView;
use App\Feed\View\YaRealty\MetroView;
use App\Feed\View\YaRealty\OfferNewFlatView;
use App\Feed\View\YaRealty\PriceView;
use App\Feed\View\YaRealty\SaleAgentView;
use App\Services\FileUrlHelper;
use DateTime;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class YaRealtyGenerator
{
    const ATTR_XMLNS = "http://webmaster.yandex.ru/schemas/feed/realty/2010-06";

    const FLAT_CARD_URL = "https://brownhouse.ru/apartment/{n}";

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var FileUrlHelper
     */
    protected $fileUrlHelper;

    public function __construct(
        FileUrlHelper $fileUrlHelper,
        $xmlContext = []
    )
    {
        $xmlContext = array_merge($this->getContext(), $xmlContext);
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToChainCaseNameConverter())];
        $encoders = [new XmlEncoder($xmlContext)];
        $this->serializer = new Serializer($normalizers,$encoders);
        $this->fileUrlHelper = $fileUrlHelper;
    }

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
                '@internal-id' => $offer->getId(),
                '#' => $offerNode
            ];
        }

        return $this->serializer->encode($data, 'xml');
    }

    protected function getRootNode(){
        $date = new DateTime();
        return [
            '@xmlns' => self::ATTR_XMLNS,
            '#' => [
                'generation-date' => ['#' => $date->format('c')]
            ]
        ];
    }

    protected function getOfferNode(Flat $flat, Contacts $contacts, Building $building, $totalFloors){
        $view = $this->getView();
        $date = new DateTime();

        $view
            ->setType(OfferNewFlatView::TYPE)
            ->setPropertyType(OfferNewFlatView::PROPERTY_TYPE)
            ->setCategory(OfferNewFlatView::CATEGORY_FLAT)
            ->setUrl($this->getFlatUrl($flat->getNumber()))
            ->setCreationDate($date->format('c'))
            ->setYandexHouseId(2593348)
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
            ->setValue($flat->getPrice())
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
            ->setNewFlat(OfferNewFlatView::BOOL_TRUE)
            ->setFloor($flat->getFloor() ? $flat->getFloor()->getNumber() : null)
        ;
        if($flat->getRooms() != Flat::ROOMS_STUDIO){
            $view->setRooms($flat->getRooms());
        }
        else{
            $view->setStudio(OfferNewFlatView::BOOL_TRUE);
        }

        $view
            ->setFloorsTotal($totalFloors)
            ->setBuiltYear($building->getDeadline())
            ->setBuildingName($building->getName())
        ;

        switch ($building->getBuildingType()){
            case Building::BUILDING_TYPE_BRICK:
                $view->setBuildingType(OfferNewFlatView::BUILDING_TYPE_BRICK);
                break;
            case Building::BUILDING_TYPE_MONOLITH:
                $view->setBuildingType(OfferNewFlatView::BUILDING_TYPE_MONOLITH);
                break;
            case Building::BUILDING_TYPE_PANEL:
                $view->setBuildingType(OfferNewFlatView::BUILDING_TYPE_PANEL);
                break;
        }

        switch ($building->getFinishType()){
            case Building::FINISH_TYPE_TURNKEY:
                $view->setRenovation(OfferNewFlatView::RENOVATION_TURNKEY);
                break;
            case Building::FINISH_TYPE_ROUGH:
                $view->setRenovation(OfferNewFlatView::RENOVATION_ROUGH);
                break;
            case Building::FINISH_TYPE_FINE:
                $view->setRenovation(OfferNewFlatView::RENOVATION_FINE);
                break;
        }

        $result = $this->serializer->normalize($view);

        $result['image'] = [];
        $result['image'][] = [
            '@tag' => 'plan',
            '#' => $this->fileUrlHelper->get($flat, 'planFile', $flat->getPlan())
        ];

        $result['location']['metro'] = [];
        $result['location']['metro'][] = [
            'name' => 'Девяткино'
        ];

        return $result;
    }


    protected function getContext(){
        return [
            'xml_format_output' => true,
            'xml_encoding' => 'utf-8',
            'xml_version' => "1.0",
            'xml_root_node_name' => 'realty-feed',
            'remove_empty_tags' => true
        ];
    }

    protected function getFlatUrl($number){
        return str_replace("{n}", $number, self::FLAT_CARD_URL);
    }

    protected function getView(){
        return new OfferNewFlatView();
    }
}