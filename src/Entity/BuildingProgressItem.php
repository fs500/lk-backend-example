<?php

namespace App\Entity;

use App\Repository\BuildingProgressItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=BuildingProgressItemRepository::class)
 * @Vich\Uploadable
 */
class BuildingProgressItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(name="photo", type="string", length=50, nullable=true)
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="photo")
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
    private $photoFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var BuildingProgress|null
     * @ORM\ManyToOne(targetEntity=BuildingProgress::class, inversedBy="items")
     */
    private $progress;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string|null $photo
     * @return BuildingProgressItem
     */
    public function setPhoto(?string $photo): BuildingProgressItem
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @param File|null $photoFile
     * @return BuildingProgressItem
     */
    public function setPhotoFile(?File $photoFile): BuildingProgressItem
    {
        $this->photoFile = $photoFile;
        $this->updateUploadedDate();
        return $this;
    }

    private function updateUploadedDate(){
        $this->uploadDate = new DateTime();
    }

    /**
     * @return DateTime|null
     */
    public function getUploadDate(): ?DateTime
    {
        return $this->uploadDate;
    }
    
    public function getProgress(): ?BuildingProgress
    {
        return $this->progress;
    }

    public function setProgress(?BuildingProgress $progress): self
    {
        $this->progress = $progress;

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
     * @return BuildingProgressItem
     */
    public function setSort(?int $sort): BuildingProgressItem
    {
        $this->sort = $sort;
        return $this;
    }
}
