<?php


namespace App\Entity\Form;


use App\Entity\Flat;

class FlatParameter
{
    const SORT_FIELD_ROOMS = "rooms";
    const SORT_FIELD_AREA = "area";
    const SORT_FIELD_FLOOR = "floor";
    const SORT_FIELD_PRICE = "price";

    const SORT_ORDER_ASC = "asc";
    const SORT_ORDER_DESC = "desc";

    /**
     * @var array|null
     */
    private $rooms = [];

    /**
     * @var int|null
     */
    private $priceMin;

    /**
     * @var int|null
     */
    private $priceMax;

    /**
     * @var float|null
     */
    private $areaMin;

    /**
     * @var float|null
     */
    private $areaMax;

    /**
     * @var int|null
     */
    private $floorMin;

    /**
     * @var int|null
     */
    private $floorMax;

    /**
     * @var array|null
     */
    private $statuses;

    /**
     * @var string|null
     */
    private $sortField;

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @return array|null
     */
    public function getRooms(): ?array
    {
        return $this->rooms;
    }

    /**
     * @param array|null $rooms
     * @return FlatParameter
     */
    public function setRooms(?array $rooms): FlatParameter
    {
        $this->rooms = $rooms;
        return $this;
    }

    public static function getRoomsChoices(){
        return Flat::getRoomsChoices();
    }

    /**
     * @return int|null
     */
    public function getPriceMin(): ?int
    {
        return $this->priceMin;
    }

    /**
     * @param int|null $priceMin
     * @return FlatParameter
     */
    public function setPriceMin(?int $priceMin): FlatParameter
    {
        $this->priceMin = $priceMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceMax(): ?int
    {
        return $this->priceMax;
    }

    /**
     * @param int|null $priceMax
     * @return FlatParameter
     */
    public function setPriceMax(?int $priceMax): FlatParameter
    {
        $this->priceMax = $priceMax;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAreaMin(): ?float
    {
        return $this->areaMin;
    }

    /**
     * @param float|null $areaMin
     * @return FlatParameter
     */
    public function setAreaMin(?float $areaMin): FlatParameter
    {
        $this->areaMin = $areaMin;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAreaMax(): ?float
    {
        return $this->areaMax;
    }

    /**
     * @param float|null $areaMax
     * @return FlatParameter
     */
    public function setAreaMax(?float $areaMax): FlatParameter
    {
        $this->areaMax = $areaMax;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloorMin(): ?int
    {
        return $this->floorMin;
    }

    /**
     * @param int|null $floorMin
     * @return FlatParameter
     */
    public function setFloorMin(?int $floorMin): FlatParameter
    {
        $this->floorMin = $floorMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloorMax(): ?int
    {
        return $this->floorMax;
    }

    /**
     * @param int|null $floorMax
     * @return FlatParameter
     */
    public function setFloorMax(?int $floorMax): FlatParameter
    {
        $this->floorMax = $floorMax;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getStatuses(): ?array
    {
        return $this->statuses;
    }

    /**
     * @param array|null $statuses
     * @return FlatParameter
     */
    public function setStatuses(?array $statuses): FlatParameter
    {
        $this->statuses = $statuses;
        return $this;
    }

    public static function getStatusesChoices(){
        return [
            Flat::STATUS_FREE => "свободна",
            Flat::STATUS_RESERVED => "забронирована",
            Flat::STATUS_SOLD => "продана",
            Flat::STATUS_CLOSED => "снята с продаж"
        ];
    }

    /**
     * @return string|null
     */
    public function getSortField(): ?string
    {
        return $this->sortField;
    }

    /**
     * @param string|null $sortField
     * @return FlatParameter
     */
    public function setSortField(?string $sortField): FlatParameter
    {
        $this->sortField = $sortField;
        return $this;
    }

    public static function getSortFieldChoices(){
        return [
            self::SORT_FIELD_ROOMS => "комнатность",
            self::SORT_FIELD_AREA => "площадь",
            self::SORT_FIELD_FLOOR => "этаж",
            self::SORT_FIELD_PRICE => "цена",
        ];
    }

    /**
     * @return string|null
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * @param string|null $sortOrder
     * @return FlatParameter
     */
    public function setSortOrder(?string $sortOrder): FlatParameter
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    public static function getSortOrderChoices(){
        return [
            self::SORT_ORDER_ASC => "asc",
            self::SORT_ORDER_DESC => "desc",
        ];
    }
}