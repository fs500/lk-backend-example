<?php

namespace App\Entity;

use App\Repository\YandexYmlOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=YandexYmlOfferRepository::class)
 */
class YandexYmlOffer
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=YandexYmlShop::class, inversedBy="offers")
     */
    private $shop;

    /**
     * @ORM\ManyToOne(targetEntity=YandexYmlCategory::class, inversedBy="offers")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=YandexYmlSet::class, inversedBy="offers")
     */
    private $sets;

    /**
     * @ORM\OneToOne(targetEntity=Flat::class, cascade={"persist", "remove"})
     */
    private $flat;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paramConversion;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var array|null
     * @ORM\Column(type="array")
     */
    private $paramEstateClass = [];

    /**
     * @var bool|null
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paramFreePlan;

    /**
     * @var string[]|null
     * @ORM\Column(type="array")
     */
    private $paramFinishing = [];

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paramRepair;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?YandexYmlCategory
    {
        return $this->category;
    }

    public function setCategory(?YandexYmlCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|YandexYmlSet[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(YandexYmlSet $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
        }

        return $this;
    }

    public function removeSet(YandexYmlSet $set): self
    {
        $this->sets->removeElement($set);

        return $this;
    }

    public function getFlat(): ?Flat
    {
        return $this->flat;
    }

    public function setFlat(?Flat $flat): self
    {
        $this->flat = $flat;

        return $this;
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
     * @return YandexYmlOffer
     */
    public function setName(?string $name): YandexYmlOffer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParamConversion(): ?int
    {
        return $this->paramConversion;
    }

    /**
     * @param int|null $paramConversion
     * @return YandexYmlOffer
     */
    public function setParamConversion(?int $paramConversion): YandexYmlOffer
    {
        $this->paramConversion = $paramConversion;
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
     * @return YandexYmlOffer
     */
    public function setDescription(?string $description): YandexYmlOffer
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getParamEstateClass(): ?array
    {
        return $this->paramEstateClass;
    }

    /**
     * @param array|null $paramEstateClass
     * @return YandexYmlOffer
     */
    public function setParamEstateClass(?array $paramEstateClass): YandexYmlOffer
    {
        $this->paramEstateClass = $paramEstateClass;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getParamFreePlan(): ?bool
    {
        return $this->paramFreePlan;
    }

    /**
     * @param bool|null $paramFreePlan
     * @return YandexYmlOffer
     */
    public function setParamFreePlan(?bool $paramFreePlan): YandexYmlOffer
    {
        $this->paramFreePlan = $paramFreePlan;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getParamFinishing(): ?array
    {
        return $this->paramFinishing;
    }

    /**
     * @param string[]|null $paramFinishing
     * @return YandexYmlOffer
     */
    public function setParamFinishing(?array $paramFinishing): YandexYmlOffer
    {
        $this->paramFinishing = $paramFinishing;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParamRepair(): ?string
    {
        return $this->paramRepair;
    }

    /**
     * @param string|null $paramRepair
     * @return YandexYmlOffer
     */
    public function setParamRepair(?string $paramRepair): YandexYmlOffer
    {
        $this->paramRepair = $paramRepair;
        return $this;
    }
}
