<?php

namespace App\Entity;

use App\Repository\PageTermsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PageTermsRepository::class)
 * @Vich\Uploadable
 */
class PageTerms
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Page|null
     * @ORM\ManyToOne(targetEntity=Page::class, inversedBy="terms")
     */
    private $page;

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
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

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
     * @return PageTerms
     */
    public function setIcon(?string $icon): PageTerms
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
     * @return string|null
     */
    public function getHeader(): ?string
    {
        return $this->header;
    }

    /**
     * @param string|null $header
     * @return PageTerms
     */
    public function setHeader(?string $header): PageTerms
    {
        $this->header = $header;
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
     * @return PageTerms
     */
    public function setText(?string $text): PageTerms
    {
        $this->text = $text;
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
     * @return PageTerms
     */
    public function setSort(?int $sort): PageTerms
    {
        $this->sort = $sort;
        return $this;
    }
}
