<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validator as AppAssert;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity("path")
 */
class News
{
    const INDEX = "index";

    /**
     * @var int|null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotEqualTo("index")
     * @Assert\NotBlank()
     * @AppAssert\PathConstraint()
     */
    private $path;

    /**
     * @var DateTime|null
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     *
     */
    private $text;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image")
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
    private $imageFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function __toString()
    {
        return $this->header ?? "";
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return News
     */
    public function setHeader(?string $header): News
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return News
     */
    public function setPath(?string $path): News
    {
        $this->path = $path;
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
     * @return News
     */
    public function setDate(?DateTime $date): News
    {
        $this->date = $date;
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
     * @return News
     */
    public function setDescription(?string $description): News
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return News
     */
    public function setText(?string $text): News
    {
        $this->text = $text;
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
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return News
     */
    public function setImage(?string $image): News
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return News
     */
    public function setImageFile(?File $imageFile): News
    {
        $this->imageFile = $imageFile;
        $this->updateDate();
        return $this;
    }
}