<?php

namespace App\Entity;

use App\Repository\InfrastructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InfrastructureRepository::class)
 * @Vich\Uploadable
 */
class Infrastructure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var InfrastructureItem[]|ArrayCollection
     * @ORM\OneToMany(targetEntity=InfrastructureItem::class, mappedBy="infrastructure", cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $items;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $header;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

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

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|InfrastructureItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(InfrastructureItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setInfrastructure($this);
        }

        return $this;
    }

    public function removeItem(InfrastructureItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getInfrastructure() === $this) {
                $item->setInfrastructure(null);
            }
        }

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
     * @return Infrastructure
     */
    public function setHeader(?string $header): Infrastructure
    {
        $this->header = $header;
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
     * @return Infrastructure
     */
    public function setSort(?int $sort): Infrastructure
    {
        $this->sort = $sort;
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
}
