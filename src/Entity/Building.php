<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=BuildingRepository::class)
 * @Vich\Uploadable
 */
class Building
{
    const BUILDING_TYPE_BRICK = "brick";
    const BUILDING_TYPE_MONOLITH = "monolith";
    const BUILDING_TYPE_PANEL = "panel";

    const FINISH_TYPE_FINE = "fine";
    const FINISH_TYPE_TURNKEY = "turnkey";
    const FINISH_TYPE_ROUGH = "rough";

    const BUILDING_STATE_BUILT = "built";
    const BUILDING_STATE_HAND_OVER = "hand_over";
    const BUILDING_STATE_UNFINISHED = "unfinished";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var BuildingPlacement[]|ArrayCollection
     * @ORM\OneToMany(targetEntity=BuildingPlacement::class, mappedBy="building", cascade={"persist","remove"})
     */
    private $placements;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $buildingState;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deadline;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $readyQuarter;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="logo")
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
    private $logoFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mapImage;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="mapImage")
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
    private $mapImageFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Url()
     */
    private $liveBroadcastURL;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Url()
     */
    private $qrCodeURL;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $buildingType;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $finishType;

    public function __construct()
    {
        $this->placements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Building
     */
    public function setName(?string $name): Building
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection|BuildingPlacement[]
     */
    public function getPlacements(): Collection
    {
        return $this->placements;
    }

    public function addPlacement(BuildingPlacement $placement): self
    {
        if (!$this->placements->contains($placement)) {
            $this->placements[] = $placement;
            $placement->setBuilding($this);
        }

        return $this;
    }

    public function removePlacement(BuildingPlacement $placement): self
    {
        if ($this->placements->removeElement($placement)) {
            // set the owning side to null (unless already changed)
            if ($placement->getBuilding() === $this) {
                $placement->setBuilding(null);
            }
        }

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
     * @return Building
     */
    public function setBuildingState(?string $buildingState): Building
    {
        $this->buildingState = $buildingState;
        return $this;
    }

    public static function getBuildingStateChoices(){
        return [
            self::BUILDING_STATE_BUILT => "дом построен, но не сдан",
            self::BUILDING_STATE_HAND_OVER => "сдан в эксплуатацию",
            self::BUILDING_STATE_UNFINISHED => "строится",
        ];
    }

    /**
     * @return int|null
     */
    public function getDeadline(): ?int
    {
        return $this->deadline;
    }

    /**
     * @param int|null $deadline
     * @return Building
     */
    public function setDeadline(?int $deadline): Building
    {
        $this->deadline = $deadline;
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
     * @return Building
     */
    public function setReadyQuarter(?int $readyQuarter): Building
    {
        $this->readyQuarter = $readyQuarter;
        return $this;
    }

    public static function getReadyQuarterChoices(){
        return [
            1 => 'первый',
            2 => 'второй',
            3 => 'третий',
            4 => 'четвертый',
        ];
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     * @return Building
     */
    public function setLogo(?string $logo): Building
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    /**
     * @param File|null $logoFile
     * @return Building
     */
    public function setLogoFile(?File $logoFile): Building
    {
        $this->logoFile = $logoFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUploadDate(): ?DateTime
    {
        return $this->uploadDate;
    }

    /**
     * @return $this
     */
    public function updateDate(){
        $this->uploadDate = new DateTime();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMapImage(): ?string
    {
        return $this->mapImage;
    }

    /**
     * @param string|null $mapImage
     * @return Building
     */
    public function setMapImage(?string $mapImage): Building
    {
        $this->mapImage = $mapImage;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getMapImageFile(): ?File
    {
        return $this->mapImageFile;
    }

    /**
     * @param File|null $mapImageFile
     * @return Building
     */
    public function setMapImageFile(?File $mapImageFile): Building
    {
        $this->mapImageFile = $mapImageFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLiveBroadcastURL(): ?string
    {
        return $this->liveBroadcastURL;
    }

    /**
     * @param string|null $liveBroadcastURL
     * @return Building
     */
    public function setLiveBroadcastURL(?string $liveBroadcastURL): Building
    {
        $this->liveBroadcastURL = $liveBroadcastURL;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQrCodeURL(): ?string
    {
        return $this->qrCodeURL;
    }

    /**
     * @param string|null $qrCodeURL
     * @return Building
     */
    public function setQrCodeURL(?string $qrCodeURL): Building
    {
        $this->qrCodeURL = $qrCodeURL;
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
     * @return Building
     */
    public function setBuildingType(?string $buildingType): Building
    {
        $this->buildingType = $buildingType;
        return $this;
    }

    public static function getBuildingTypeChoices(){
        return [
            self::BUILDING_TYPE_BRICK => "кирпичный",
            self::BUILDING_TYPE_MONOLITH => "монолит",
            self::BUILDING_TYPE_PANEL => "панель",
        ];
    }

    /**
     * @return string|null
     */
    public function getFinishType(): ?string
    {
        return $this->finishType;
    }

    /**
     * @param string|null $finishType
     * @return Building
     */
    public function setFinishType(?string $finishType): Building
    {
        $this->finishType = $finishType;
        return $this;
    }

    public static function getFinishTypeChoices(){
        return [
            self::FINISH_TYPE_FINE => "чистовая отделка",
            self::FINISH_TYPE_ROUGH => "черновая отделка",
            self::FINISH_TYPE_TURNKEY => "под ключ"
        ];
    }
}
