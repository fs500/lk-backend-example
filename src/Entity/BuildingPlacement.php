<?php

namespace App\Entity;

use App\Repository\BuildingPlacementRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=BuildingPlacementRepository::class)
 * @Vich\Uploadable()
 */
class BuildingPlacement
{
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
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="placements")
     */
    private $building;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="icon")
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
    private $iconFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeader(): ?string
    {
        return $this->header;
    }

    /**
     * @param string|null $header
     * @return BuildingPlacement
     */
    public function setHeader(?string $header): BuildingPlacement
    {
        $this->header = $header;
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
     * @return BuildingPlacement
     */
    public function setDescription(?string $description): BuildingPlacement
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string|null $icon
     * @return $this
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    /**
     * @param File|null $iconFile
     * @return $this
     */
    public function setIconFile(?File $iconFile): self
    {
        $this->iconFile = $iconFile;
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
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     * @return BuildingPlacement
     */
    public function setSort(?int $sort): BuildingPlacement
    {
        $this->sort = $sort;
        return $this;
    }
}
