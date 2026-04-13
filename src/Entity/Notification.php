<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 * @Vich\Uploadable
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateStart;

    /**
     * @var DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFinish;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $buttonText;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $buttonUrl;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime|null
     */
    public function getDateStart(): ?DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param DateTime|null $dateStart
     * @return Notification
     */
    public function setDateStart(?DateTime $dateStart): Notification
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateFinish(): ?DateTime
    {
        return $this->dateFinish;
    }

    /**
     * @param DateTime|null $dateFinish
     * @return Notification
     */
    public function setDateFinish(?DateTime $dateFinish): Notification
    {
        $this->dateFinish = $dateFinish;
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
     */
    public function setHeader(?string $header): void
    {
        $this->header = $header;
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
     * @return Notification
     */
    public function setText(?string $text): Notification
    {
        $this->text = $text;
        return $this;
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
     * @return $this
     */
    public function setImage(?string $image): self
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
     * @return $this
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getButtonText(): ?string
    {
        return $this->buttonText;
    }

    /**
     * @param string|null $buttonText
     */
    public function setButtonText(?string $buttonText): void
    {
        $this->buttonText = $buttonText;
    }

    /**
     * @return string|null
     */
    public function getButtonUrl(): ?string
    {
        return $this->buttonUrl;
    }

    /**
     * @param string|null $buttonUrl
     */
    public function setButtonUrl(?string $buttonUrl): void
    {
        $this->buttonUrl = $buttonUrl;
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
}
