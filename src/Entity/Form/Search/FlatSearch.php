<?php


namespace App\Entity\Form\Search;


use App\Entity\Floor;
use Symfony\Component\Validator\Constraints as Assert;

class FlatSearch extends AbstractSearch
{
    /**
     * @var int|null
     * @Assert\Positive()
     */
    private $number;

    /**
     * @var Floor|null
     */
    private $floor;

    /**
     * @var string|null
     */
    private $rooms;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var int|null
     * @Assert\Positive()
     */
    private $price;

    /**
     * @var int|null
     * @Assert\Positive()
     */
    private $priceFinish;

    /**
     * @var int|null
     * @Assert\Positive()
     */
    private $priceAction;

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     * @return FlatSearch
     */
    public function setNumber(?int $number): FlatSearch
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return Floor|null
     */
    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    /**
     * @param Floor|null $floor
     * @return FlatSearch
     */
    public function setFloor(?Floor $floor): FlatSearch
    {
        $this->floor = $floor;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRooms(): ?string
    {
        return $this->rooms;
    }

    /**
     * @param string|null $rooms
     * @return FlatSearch
     */
    public function setRooms(?string $rooms): FlatSearch
    {
        $this->rooms = $rooms;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return FlatSearch
     */
    public function setStatus(?string $status): FlatSearch
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return FlatSearch
     */
    public function setPrice(?int $price): FlatSearch
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceFinish(): ?int
    {
        return $this->priceFinish;
    }

    /**
     * @param int|null $priceFinish
     * @return FlatSearch
     */
    public function setPriceFinish(?int $priceFinish): FlatSearch
    {
        $this->priceFinish = $priceFinish;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceAction(): ?int
    {
        return $this->priceAction;
    }

    /**
     * @param int|null $priceAction
     */
    public function setPriceAction(?int $priceAction): void
    {
        $this->priceAction = $priceAction;
    }

}