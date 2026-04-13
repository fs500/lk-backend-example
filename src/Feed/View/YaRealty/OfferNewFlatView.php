<?php


namespace App\Feed\View\YaRealty;


class OfferNewFlatView
{
    const YANDEX_HOUSE_ID = 2593348;
    const YANDEX_BUILDING_ID = 2593206;

    const BOOL_TRUE = "да";
    const BOOL_FALSE = "нет";

    const TYPE = "продажа";

    const PROPERTY_TYPE = "жилая";

    const CATEGORY_HOUSE = "дом";
    const CATEGORY_FLAT = "квартира";
    const CATEGORY_TOWNHOUSE = "таунхаус";

    const DEAL_STATUS_DEVELOPER = "первичная продажа";
    const DEAL_STATUS_DIRECT = "прямая продажа";
    const DEAL_STATUS_REASSIGNMENT = "переуступка";

    const RENOVATION_FINE = "чистовая отделка";
    const RENOVATION_TURNKEY = "под ключ";
    const RENOVATION_ROUGH = "черновая отделка";

    const ROOMS_TYPE_ADJOINING = "смежные";
    const ROOMS_TYPE_SEPARATED = "раздельные";

    const WINDOW_VIEW_YARD = "во двор";
    const WINDOW_VIEW_STREET = "на улицу";

    const FLOOR_COVERING_CARPET = "ковролин";
    const FLOOR_COVERING_LAMINATE = "ламинат";
    const FLOOR_COVERING_LINOLEUM = "линолеум";
    const FLOOR_COVERING_PARQUET = "паркет";

    const BATHROOM_UNIT_ADJOINING = "совмещенный";
    const BATHROOM_UNIT_SEPARATED = "раздельный";

    const BUILDING_STATE_BUILT = "built";
    const BUILDING_STATE_HAND_OVER = "hand-over";
    const BUILDING_STATE_UNFINISHED = "unfinished";

    const BUILDING_TYPE_BRICK = "кирпичный";
    const BUILDING_TYPE_MONOLITH = "монолит";
    const BUILDING_TYPE_PANEL = "панельный";

    /**
     * @var string|null
     */
    protected $type;

    /**
     * @var string|null
     */
    protected $propertyType;

    /**
     * @var string|null
     */
    protected $category;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var string|null
     */
    protected $creationDate;

    /**
     * @var LocationView|null
     */
    protected $location;

    /**
     * @var SaleAgentView|null
     */
    protected $salesAgent;

    /**
     * @var string|null
     */
    protected $dealStatus;

    /**
     * @var PriceView|null
     */
    protected $price;

    /**
     * @var string|null
     */
    protected $isImageOrderChangeAllowed;

    /**
     * @var AreaView|null
     */
    protected $area;

    /**
     * @var AreaView|null
     */
    protected $livingSpace;

    /**
     * @var AreaView|null
     */
    protected $kitchenSpace;

    /**
     * @var string|null;
     */
    protected $renovation;

    /**
     * @var string|null;
     */
    protected $description;

    /**
     * @var string|null;
     */
    protected $videoReview;

    /**
     * @var string|null
     */
    protected $newFlat;

    /**
     * @var int|null
     */
    protected $floor;

    /**
     * @var int|null
     */
    protected $rooms;

    /**
     * @var string|null
     */
    protected $roomsType;

    /**
     * @var string|null
     */
    protected $apartments;

    /**
     * @var string|null
     */
    protected $studio;

    /**
     * @var string|null
     */
    protected $openPlan;

    /**
     * @var string|null
     */
    protected $balcony;

    /**
     * @var string|null
     */
    protected $windowView;

    /**
     * @var string|null
     */
    protected $floorCovering;

    /**
     * @var string|int|null;
     */
    protected $bathroomUnit;

    /**
     * @var int|null
     */
    protected $floorsTotal;

    /**
     * @var string|null
     */
    protected $buildingName;

    /**
     * @var int|null
     */
    protected $yandexBuildingId;

    /**
     * @var int|null
     */
    protected $yandexHouseId;

    /**
     * @var string|null
     */
    protected $buildingState;

    /**
     * @var int|string|null
     */
    protected $builtYear;

    /**
     * @var int|null
     */
    protected $readyQuarter;

    /**
     * @var string|null
     */
    protected $buildingPhase;

    /**
     * @var string|null
     */
    protected $buildingType;

    /**
     * @var string|null
     */
    protected $buildingSeries;

    /**
     * @var string|null
     */
    protected $buildingSection;

    /**
     * @var int|float|null
     */
    protected $ceilingHeight;

    /**
     * @var string|null
     */
    protected $lift;

    /**
     * @var string|null
     */
    protected $rubbishChute;

    /**
     * @var string|null
     */
    protected $guardedBuilding;

    /**
     * @var string|null
     */
    protected $parking;

    /**
     * @var string|null
     */
    protected $isElite;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return OfferNewFlatView
     */
    public function setType(?string $type): OfferNewFlatView
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPropertyType(): ?string
    {
        return $this->propertyType;
    }

    /**
     * @param string|null $propertyType
     * @return OfferNewFlatView
     */
    public function setPropertyType(?string $propertyType): OfferNewFlatView
    {
        $this->propertyType = $propertyType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return OfferNewFlatView
     */
    public function setCategory(?string $category): OfferNewFlatView
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return OfferNewFlatView
     */
    public function setUrl(?string $url): OfferNewFlatView
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    /**
     * @param string|null $creationDate
     * @return OfferNewFlatView
     */
    public function setCreationDate(?string $creationDate): OfferNewFlatView
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return LocationView|null
     */
    public function getLocation(): ?LocationView
    {
        return $this->location;
    }

    /**
     * @param LocationView|null $location
     * @return OfferNewFlatView
     */
    public function setLocation(?LocationView $location): OfferNewFlatView
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return SaleAgentView|null
     */
    public function getSalesAgent(): ?SaleAgentView
    {
        return $this->salesAgent;
    }

    /**
     * @param SaleAgentView|null $salesAgent
     * @return OfferNewFlatView
     */
    public function setSalesAgent(?SaleAgentView $salesAgent): OfferNewFlatView
    {
        $this->salesAgent = $salesAgent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDealStatus(): ?string
    {
        return $this->dealStatus;
    }

    /**
     * @param string|null $dealStatus
     * @return OfferNewFlatView
     */
    public function setDealStatus(?string $dealStatus): OfferNewFlatView
    {
        $this->dealStatus = $dealStatus;
        return $this;
    }

    /**
     * @return PriceView|null
     */
    public function getPrice(): ?PriceView
    {
        return $this->price;
    }

    /**
     * @param PriceView|null $price
     * @return OfferNewFlatView
     */
    public function setPrice(?PriceView $price): OfferNewFlatView
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsImageOrderChangeAllowed(): ?string
    {
        return $this->isImageOrderChangeAllowed;
    }

    /**
     * @param string|null $isImageOrderChangeAllowed
     * @return OfferNewFlatView
     */
    public function setIsImageOrderChangeAllowed(?string $isImageOrderChangeAllowed): OfferNewFlatView
    {
        $this->isImageOrderChangeAllowed = $isImageOrderChangeAllowed;
        return $this;
    }

    /**
     * @return AreaView|null
     */
    public function getArea(): ?AreaView
    {
        return $this->area;
    }

    /**
     * @param AreaView|null $area
     * @return OfferNewFlatView
     */
    public function setArea(?AreaView $area): OfferNewFlatView
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return AreaView|null
     */
    public function getLivingSpace(): ?AreaView
    {
        return $this->livingSpace;
    }

    /**
     * @param AreaView|null $livingSpace
     * @return OfferNewFlatView
     */
    public function setLivingSpace(?AreaView $livingSpace): OfferNewFlatView
    {
        $this->livingSpace = $livingSpace;
        return $this;
    }

    /**
     * @return AreaView|null
     */
    public function getKitchenSpace(): ?AreaView
    {
        return $this->kitchenSpace;
    }

    /**
     * @param AreaView|null $kitchenSpace
     * @return OfferNewFlatView
     */
    public function setKitchenSpace(?AreaView $kitchenSpace): OfferNewFlatView
    {
        $this->kitchenSpace = $kitchenSpace;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRenovation(): ?string
    {
        return $this->renovation;
    }

    /**
     * @param string|null $renovation
     * @return OfferNewFlatView
     */
    public function setRenovation(?string $renovation): OfferNewFlatView
    {
        $this->renovation = $renovation;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return OfferNewFlatView
     */
    public function setDescription(?string $description): OfferNewFlatView
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVideoReview(): ?string
    {
        return $this->videoReview;
    }

    /**
     * @param string|null $videoReview
     * @return OfferNewFlatView
     */
    public function setVideoReview(?string $videoReview): OfferNewFlatView
    {
        $this->videoReview = $videoReview;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewFlat(): ?string
    {
        return $this->newFlat;
    }

    /**
     * @param string|null $newFlat
     * @return OfferNewFlatView
     */
    public function setNewFlat(?string $newFlat): OfferNewFlatView
    {
        $this->newFlat = $newFlat;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloor(): ?int
    {
        return $this->floor;
    }

    /**
     * @param int|null $floor
     * @return OfferNewFlatView
     */
    public function setFloor(?int $floor): OfferNewFlatView
    {
        $this->floor = $floor;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    /**
     * @param int|null $rooms
     * @return OfferNewFlatView
     */
    public function setRooms(?int $rooms): OfferNewFlatView
    {
        $this->rooms = $rooms;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoomsType(): ?string
    {
        return $this->roomsType;
    }

    /**
     * @param string|null $roomsType
     * @return OfferNewFlatView
     */
    public function setRoomsType(?string $roomsType): OfferNewFlatView
    {
        $this->roomsType = $roomsType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApartments(): ?string
    {
        return $this->apartments;
    }

    /**
     * @param string|null $apartments
     * @return OfferNewFlatView
     */
    public function setApartments(?string $apartments): OfferNewFlatView
    {
        $this->apartments = $apartments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStudio(): ?string
    {
        return $this->studio;
    }

    /**
     * @param string|null $studio
     * @return OfferNewFlatView
     */
    public function setStudio(?string $studio): OfferNewFlatView
    {
        $this->studio = $studio;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOpenPlan(): ?string
    {
        return $this->openPlan;
    }

    /**
     * @param string|null $openPlan
     * @return OfferNewFlatView
     */
    public function setOpenPlan(?string $openPlan): OfferNewFlatView
    {
        $this->openPlan = $openPlan;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBalcony(): ?string
    {
        return $this->balcony;
    }

    /**
     * @param string|null $balcony
     * @return OfferNewFlatView
     */
    public function setBalcony(?string $balcony): OfferNewFlatView
    {
        $this->balcony = $balcony;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWindowView(): ?string
    {
        return $this->windowView;
    }

    /**
     * @param string|null $windowView
     * @return OfferNewFlatView
     */
    public function setWindowView(?string $windowView): OfferNewFlatView
    {
        $this->windowView = $windowView;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFloorCovering(): ?string
    {
        return $this->floorCovering;
    }

    /**
     * @param string|null $floorCovering
     * @return OfferNewFlatView
     */
    public function setFloorCovering(?string $floorCovering): OfferNewFlatView
    {
        $this->floorCovering = $floorCovering;
        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getBathroomUnit()
    {
        return $this->bathroomUnit;
    }

    /**
     * @param int|string|null $bathroomUnit
     * @return OfferNewFlatView
     */
    public function setBathroomUnit($bathroomUnit)
    {
        $this->bathroomUnit = $bathroomUnit;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloorsTotal(): ?int
    {
        return $this->floorsTotal;
    }

    /**
     * @param int|null $floorsTotal
     * @return OfferNewFlatView
     */
    public function setFloorsTotal(?int $floorsTotal): OfferNewFlatView
    {
        $this->floorsTotal = $floorsTotal;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingName(): ?string
    {
        return $this->buildingName;
    }

    /**
     * @param string|null $buildingName
     * @return OfferNewFlatView
     */
    public function setBuildingName(?string $buildingName): OfferNewFlatView
    {
        $this->buildingName = $buildingName;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getYandexBuildingId(): ?int
    {
        return $this->yandexBuildingId;
    }

    /**
     * @param int|null $yandexBuildingId
     * @return OfferNewFlatView
     */
    public function setYandexBuildingId(?int $yandexBuildingId): OfferNewFlatView
    {
        $this->yandexBuildingId = $yandexBuildingId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getYandexHouseId(): ?int
    {
        return $this->yandexHouseId;
    }

    /**
     * @param int|null $yandexHouseId
     * @return OfferNewFlatView
     */
    public function setYandexHouseId(?int $yandexHouseId): OfferNewFlatView
    {
        $this->yandexHouseId = $yandexHouseId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingState(): ?string
    {
        return $this->buildingState;
    }

    /**
     * @param string|null $buildingState
     * @return OfferNewFlatView
     */
    public function setBuildingState(?string $buildingState): OfferNewFlatView
    {
        $this->buildingState = $buildingState;
        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getBuiltYear()
    {
        return $this->builtYear;
    }

    /**
     * @param int|string|null $builtYear
     * @return OfferNewFlatView
     */
    public function setBuiltYear($builtYear): OfferNewFlatView
    {
        $this->builtYear = $builtYear;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReadyQuarter(): ?int
    {
        return $this->readyQuarter;
    }

    /**
     * @param int|null $readyQuarter
     * @return OfferNewFlatView
     */
    public function setReadyQuarter(?int $readyQuarter): OfferNewFlatView
    {
        $this->readyQuarter = $readyQuarter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingPhase(): ?string
    {
        return $this->buildingPhase;
    }

    /**
     * @param string|null $buildingPhase
     * @return OfferNewFlatView
     */
    public function setBuildingPhase(?string $buildingPhase): OfferNewFlatView
    {
        $this->buildingPhase = $buildingPhase;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingType(): ?string
    {
        return $this->buildingType;
    }

    /**
     * @param string|null $buildingType
     * @return OfferNewFlatView
     */
    public function setBuildingType(?string $buildingType): OfferNewFlatView
    {
        $this->buildingType = $buildingType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingSeries(): ?string
    {
        return $this->buildingSeries;
    }

    /**
     * @param string|null $buildingSeries
     * @return OfferNewFlatView
     */
    public function setBuildingSeries(?string $buildingSeries): OfferNewFlatView
    {
        $this->buildingSeries = $buildingSeries;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBuildingSection(): ?string
    {
        return $this->buildingSection;
    }

    /**
     * @param string|null $buildingSection
     * @return OfferNewFlatView
     */
    public function setBuildingSection(?string $buildingSection): OfferNewFlatView
    {
        $this->buildingSection = $buildingSection;
        return $this;
    }

    /**
     * @return float|int|null
     */
    public function getCeilingHeight()
    {
        return $this->ceilingHeight;
    }

    /**
     * @param float|int|null $ceilingHeight
     * @return OfferNewFlatView
     */
    public function setCeilingHeight($ceilingHeight)
    {
        $this->ceilingHeight = $ceilingHeight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLift(): ?string
    {
        return $this->lift;
    }

    /**
     * @param string|null $lift
     * @return OfferNewFlatView
     */
    public function setLift(?string $lift): OfferNewFlatView
    {
        $this->lift = $lift;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRubbishChute(): ?string
    {
        return $this->rubbishChute;
    }

    /**
     * @param string|null $rubbishChute
     * @return OfferNewFlatView
     */
    public function setRubbishChute(?string $rubbishChute): OfferNewFlatView
    {
        $this->rubbishChute = $rubbishChute;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuardedBuilding(): ?string
    {
        return $this->guardedBuilding;
    }

    /**
     * @param string|null $guardedBuilding
     * @return OfferNewFlatView
     */
    public function setGuardedBuilding(?string $guardedBuilding): OfferNewFlatView
    {
        $this->guardedBuilding = $guardedBuilding;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParking(): ?string
    {
        return $this->parking;
    }

    /**
     * @param string|null $parking
     * @return OfferNewFlatView
     */
    public function setParking(?string $parking): OfferNewFlatView
    {
        $this->parking = $parking;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsElite(): ?string
    {
        return $this->isElite;
    }

    /**
     * @param string|null $isElite
     * @return OfferNewFlatView
     */
    public function setIsElite(?string $isElite): OfferNewFlatView
    {
        $this->isElite = $isElite;
        return $this;
    }
}