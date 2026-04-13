<?php

namespace App\Entity;

use App\Repository\PageSliderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=PageSliderRepository::class)
 * @Vich\Uploadable
 */
class PageSlide
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Page|null
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="slides")
     */
    private $page;

    /**
     * @var string|null
     * @ORM\Column(name="image", type="string", length=50, nullable=true)
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
     *          "image/png"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png"
     * )
     */
    private $imageFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

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
     * @var Link|null
     * @ORM\ManyToOne(targetEntity=Link::class, cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $link;

    /**
     * @var Link|null
     * @ORM\ManyToOne(targetEntity=Link::class, cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $liveBroadcast;

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
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->page;
    }

    /**
     * @param Page|null $page
     * @return PageSlide
     */
    public function setPage(?Page $page): self
    {
        $this->page = $page;
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
     * @return PageSlide
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
     * @return PageSlide
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
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
    public function updateDate(): self
    {
        $this->uploadDate = new DateTime();
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
     * @return PageSlide
     */
    public function setHeader(?string $header): self
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
     * @return PageSlide
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Link|null
     */
    public function getLink(): ?Link
    {
        return $this->link;
    }

    /**
     * @param Link|null $link
     * @return PageSlide
     */
    public function setLink(?Link $link): self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return Link|null
     */
    public function getLiveBroadcast(): ?Link
    {
        return $this->liveBroadcast;
    }

    /**
     * @param Link|null $liveBroadcast
     * @return PageSlide
     */
    public function setLiveBroadcast(?Link $liveBroadcast): self
    {
        $this->liveBroadcast = $liveBroadcast;
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
     * @return PageSlide
     */
    public function setSort(?int $sort): self
    {
        $this->sort = $sort;
        return $this;
    }
}
