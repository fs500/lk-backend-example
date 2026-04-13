<?php

namespace App\Entity;

use App\Repository\YandexYmlSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=YandexYmlSetRepository::class)
 */
class YandexYmlSet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=YandexYmlShop::class, inversedBy="sets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    private $url;

    /**
     * @ORM\ManyToMany(targetEntity=YandexYmlOffer::class, mappedBy="sets")
     */
    private $offers;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
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

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return YandexYmlSet
     */
    public function setName(?string $name): YandexYmlSet
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return YandexYmlSet
     */
    public function setUrl(?string $url): YandexYmlSet
    {
        $this->url = $url;
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
            $offer->addSet($this);
        }

        return $this;
    }

    public function removeOffer(YandexYmlOffer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            $offer->removeSet($this);
        }

        return $this;
    }
}
