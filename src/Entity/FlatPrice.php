<?php

namespace App\Entity;

use App\Repository\FlatPriceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FlatPriceRepository::class)
 */
class FlatPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var array|null
     * @ORM\Column(type="array", nullable=true)
     * @Assert\NotBlank()
     */
    private $floors;

    /**
     * @var array|null
     * @ORM\Column(type="array", nullable=true)
     * @Assert\NotBlank()
     */
    private $rooms;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getFloors(): ?array
    {
        return $this->floors;
    }

    /**
     * @param array|null $floors
     * @return FlatPrice
     */
    public function setFloors(?array $floors): FlatPrice
    {
        $this->floors = $floors;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getRooms(): ?array
    {
        return $this->rooms;
    }

    /**
     * @param array|null $rooms
     * @return FlatPrice
     */
    public function setRooms(?array $rooms): FlatPrice
    {
        $this->rooms = $rooms;
        return $this;
    }

    public static function getRoomsChoices(){
        return Flat::getRoomsChoices();
    }

    public function getRoomsDescription(){
        $result = [];
        $choices = self::getRoomsChoices();
        foreach ($this->rooms as $room){
            if(isset($choices[$room])){
                $result[] = $choices[$room];
            }
        }
        return $result;
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
     * @return FlatPrice
     */
    public function setPrice(?int $price): FlatPrice
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date
     * @return FlatPrice
     */
    public function setDate(?DateTime $date): FlatPrice
    {
        $this->date = $date;
        return $this;
    }
}
