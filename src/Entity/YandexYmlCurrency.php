<?php

namespace App\Entity;

use App\Repository\YandexYmlCurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=YandexYmlCurrencyRepository::class)
 */
class YandexYmlCurrency
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     * @Assert\NotBlank()
     */
    private $rate;

    /**
     * @ORM\OneToMany(targetEntity=YandexYmlOffer::class, mappedBy="currency")
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

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return YandexYmlCurrency
     */
    public function setName(?string $name): YandexYmlCurrency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * @param float|null $rate
     * @return YandexYmlCurrency
     */
    public function setRate(?float $rate): YandexYmlCurrency
    {
        $this->rate = $rate;
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
            $offer->setCurrency($this);
        }

        return $this;
    }

    public function removeOffer(YandexYmlOffer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getCurrency() === $this) {
                $offer->setCurrency(null);
            }
        }

        return $this;
    }
}
