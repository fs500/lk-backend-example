<?php

namespace App\Entity;

use App\Repository\YandexYmlCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=YandexYmlCategoryRepository::class)
 */
class YandexYmlCategory
{
    const ROOMS_TYPE_STUDIO = 0;
    const ROOMS_TYPE_1 = 1;
    const ROOMS_TYPE_2 = 2;
    const ROOMS_TYPE_3 = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $header;

    /**
     * @ORM\OneToMany(targetEntity=YandexYmlOffer::class, mappedBy="category")
     */
    private $offers;

    /**
     * @ORM\ManyToOne(targetEntity=YandexYmlShop::class, inversedBy="categories")
     */
    private $shop;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $roomsType;

    /**
     * @ORM\ManyToOne(targetEntity=YandexYmlCategory::class, inversedBy="childs")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=YandexYmlCategory::class, mappedBy="parent")
     */
    private $childs;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->childs = new ArrayCollection();
    }

    public function __toString(){
        return $this->header;
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
     * @return YandexYmlCategory
     */
    public function setHeader(?string $header): YandexYmlCategory
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return Collection|YandexYmlOffer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(YandexYmlOffer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setCategory($this);
        }

        return $this;
    }

    public function removeOffer(YandexYmlOffer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getCategory() === $this) {
                $offer->setCategory(null);
            }
        }

        return $this;
    }

    public function getShop(): ?YandexYmlShop
    {
        return $this->shop;
    }

    public function setShop(?YandexYmlShop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRoomsType(): ?int
    {
        return $this->roomsType;
    }

    /**
     * @param int|null $roomsType
     * @return YandexYmlCategory
     */
    public function setRoomsType(?int $roomsType): YandexYmlCategory
    {
        $this->roomsType = $roomsType;
        return $this;
    }

    /**
     * @return string[]
     */
    public static function getRoomsTypeChoices(): array
    {
        return [
            self::ROOMS_TYPE_STUDIO => "Студия",
            self::ROOMS_TYPE_1 => "1-комнатная",
            self::ROOMS_TYPE_2 => "2-комнатная",
            self::ROOMS_TYPE_3 => "3-комнатная",
        ];
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}
