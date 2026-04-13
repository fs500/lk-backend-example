<?php

namespace App\Entity;

use App\Repository\FlatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=FlatRepository::class)
 * @ORM\EntityListeners({"App\Event\EntityListener\FlatPlanConverterListener"})
 * @Vich\Uploadable
 */
class Flat
{
    const ROOMS_STUDIO = "s";
    const ROOMS_1 = "1";
    const ROOMS_2 = "2";
    const ROOMS_3 = "3";

    const STATUS_FREE = "free";
    const STATUS_RESERVED = "reserved";
    const STATUS_SOLD = "sold";
    const STATUS_CLOSED = "closed";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Floor|null
     * @ORM\ManyToOne(targetEntity=Floor::class, inversedBy="flats")
     */
    private $floor;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $number;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $plan;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="plan")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "image/jpg",
     *          "image/jpeg",
     *          "image/gif",
     *          "image/png",
     *          "image/svg+xml"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png, svg"
     * )
     */
    private $planFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $convertedPlan;

    /**
     * @Vich\UploadableField(mapping="converted", fileNameProperty="convertedPlan")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "image/jpg",
     *          "image/jpeg",
     *          "image/gif",
     *          "image/png"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png"
     * )
     */
    private $convertedPlanFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $plan3d;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="plan3d")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "image/jpg",
     *          "image/jpeg",
     *          "image/gif",
     *          "image/png",
     *          "image/svg+xml"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png, svg"
     * )
     */
    private $plan3dFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $planUrl;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $rooms;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=5, scale=2, nullable=true)
     */
    private $area;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=5, scale=2, nullable=true)
     */
    private $roomsArea;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=5, scale=2, nullable=true)
     */
    private $kitchenArea;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceM;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceFinish;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceFinishM;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceAction;

    /**
     * @var float|null
     * @ORM\Column(type="float", precision=3, scale=2, nullable=true)
     */
    private $ceilingHeight;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(){
        return "Квартира №" . $this->number . ", " . $this->floor->getNumber() . " этаж";
    }

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): self
    {
        $this->floor = $floor;

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
     * @return Flat
     */
    public function setStatus(?string $status): Flat
    {
        $this->status = $status;
        return $this;
    }

    public static function getStatusChoices(){
        return [
            self::STATUS_FREE => "в продаже",
            self::STATUS_RESERVED => "забронировано",
            self::STATUS_SOLD => "продано",
            self::STATUS_CLOSED => "снято с продаж",
        ];
    }

    public function getStatusHeader(){
        $statuses = self::getStatusChoices();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : null;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     * @return Flat
     */
    public function setNumber(?int $number): Flat
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlan(): ?string
    {
        return $this->plan;
    }

    /**
     * @param string|null $plan
     * @return Flat
     */
    public function setPlan(?string $plan): Flat
    {
        $this->plan = $plan;
        if(is_null($plan)){
            $this->convertedPlan = null;
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPlanFile(): ?File
    {
        return $this->planFile;
    }

    /**
     * @param File|null $planFile
     * @return Flat
     */
    public function setPlanFile(?File $planFile): Flat
    {
        $this->planFile = $planFile;
        if(!is_null($planFile)){
            $this->convertedPlan = null;
            $this->updateDate();
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConvertedPlan(): ?string
    {
        return $this->convertedPlan;
    }

    /**
     * @param string|null $convertedPlan
     * @return Flat
     */
    public function setConvertedPlan(?string $convertedPlan): Flat
    {
        $this->convertedPlan = $convertedPlan;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getConvertedPlanFile(): ?File
    {
        return $this->convertedPlanFile;
    }

    /**
     * @param File|null $convertedPlanFile
     * @return Flat
     */
    public function setConvertedPlanFile(?File $convertedPlanFile): Flat
    {
        $this->convertedPlanFile = $convertedPlanFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlan3d(): ?string
    {
        return $this->plan3d;
    }

    /**
     * @param string|null $plan3d
     * @return Flat
     */
    public function setPlan3d(?string $plan3d): Flat
    {
        $this->plan3d = $plan3d;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPlan3dFile(): ?File
    {
        return $this->plan3dFile;
    }

    /**
     * @param File|null $plan3dFile
     * @return Flat
     */
    public function setPlan3dFile(?File $plan3dFile): Flat
    {
        $this->plan3dFile = $plan3dFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlanUrl(): ?string
    {
        return $this->planUrl;
    }

    /**
     * @param string|null $planUrl
     * @return Flat
     */
    public function setPlanUrl(?string $planUrl): Flat
    {
        $this->planUrl = $planUrl;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUploadDate(): ?DateTime
    {
        return $this->uploadDate;
    }

    protected function updateDate(){
        $this->uploadDate = new DateTime();
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
     * @return Flat
     */
    public function setRooms(?string $rooms): Flat
    {
        $this->rooms = $rooms;
        return $this;
    }

    public static function getRoomsChoices(){
        return [
            self::ROOMS_STUDIO => 'студия',
            self::ROOMS_1 => '1-комнатная',
            self::ROOMS_2 => '2-комнатная',
            self::ROOMS_3 => '3-комнатная',
        ];
    }

    /**
     * @param Flat $flat1
     * @param Flat $flat2
     * @return int
     */
    public static function sortByRooms($flat1, $flat2){
        $rooms = [
            Flat::ROOMS_STUDIO => 0,
            Flat::ROOMS_1 => 1,
            Flat::ROOMS_2 => 2,
            Flat::ROOMS_3 => 3,
        ];
        $f1 = isset($rooms[$flat1->getRooms()]) ? $rooms[$flat1->getRooms()] : 0;
        $f2 = isset($rooms[$flat2->getRooms()]) ? $rooms[$flat2->getRooms()] : 0;
        if($f1 == $f2){
            return 0;
        }

        return ($f1 > $f2) ? +1 : -1;
    }

    public function getRoomsHeader(){
        $rooms = self::getRoomsChoices();
        return isset($rooms[$this->rooms]) ? $rooms[$this->rooms] : null;
    }

    public function getRoomsFullHeader(){
        $rooms = self::getRoomsChoices();
        $result = isset($rooms[$this->rooms]) ? $rooms[$this->rooms] : null;
        if($this->rooms != self::ROOMS_STUDIO){
            $result .= " квартира";
        }
        return $result;
    }

    /**
     * @return float|null
     */
    public function getArea(): ?float
    {
        return $this->area;
    }

    /**
     * @param float|null $area
     * @return Flat
     */
    public function setArea(?float $area): Flat
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRoomsArea(): ?float
    {
        return $this->roomsArea;
    }

    /**
     * @param float|null $roomsArea
     * @return Flat
     */
    public function setRoomsArea(?float $roomsArea): Flat
    {
        $this->roomsArea = $roomsArea;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getKitchenArea(): ?float
    {
        return $this->kitchenArea;
    }

    /**
     * @param float|null $kitchenArea
     * @return Flat
     */
    public function setKitchenArea(?float $kitchenArea): Flat
    {
        $this->kitchenArea = $kitchenArea;
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
     * @return Flat
     */
    public function setPrice(?int $price): Flat
    {
        $this->price = $price;
        return $this;
    }

    public function getFormattedPrice(){
        return number_format($this->price,0, '.', ' ');
    }

    public function getFormattedPriceFinish(){
        return number_format($this->priceFinish,0, '.', ' ');
    }

    /**
     * @return int|null
     */
    public function getPriceM(): ?int
    {
        return $this->priceM;
    }

    /**
     * @param int|null $priceM
     * @return Flat
     */
    public function setPriceM(?int $priceM): Flat
    {
        $this->priceM = $priceM;
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
     * @return Flat
     */
    public function setPriceFinish(?int $priceFinish): Flat
    {
        $this->priceFinish = $priceFinish;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPriceFinishM(): ?int
    {
        return $this->priceFinishM;
    }

    /**
     * @param int|null $priceFinishM
     * @return Flat
     */
    public function setPriceFinishM(?int $priceFinishM): Flat
    {
        $this->priceFinishM = $priceFinishM;
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

    /**
     * @return float|null
     */
    public function getCeilingHeight(): ?float
    {
        return $this->ceilingHeight;
    }

    /**
     * @param float|null $ceilingHeight
     * @return Flat
     */
    public function setCeilingHeight(?float $ceilingHeight): Flat
    {
        $this->ceilingHeight = $ceilingHeight;
        return $this;
    }

    public function isInSales(){
        return $this->status == self::STATUS_FREE || $this->status == self::STATUS_RESERVED;
    }
}
