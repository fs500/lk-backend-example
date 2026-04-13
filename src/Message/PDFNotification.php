<?php


namespace App\Message;


use App\Entity\Flat;
use App\Entity\Floor;
use Symfony\Component\HttpFoundation\Request;

class PDFNotification
{

    /**
     * @var int|null
     */
    private $flat;

    /**
     * @var int|null
     */
    private $floor;

    /**
     * @return int|null
     */
    public function getFlat(): ?int
    {
        return $this->flat;
    }

    /**
     * @param int|null $flat
     * @return PDFNotification
     */
    public function setFlat(?int $flat): PDFNotification
    {
        $this->flat = $flat;
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
     * @return PDFNotification
     */
    public function setFloor(?int $floor): PDFNotification
    {
        $this->floor = $floor;
        return $this;
    }
}