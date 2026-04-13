<?php

namespace App\Entity;

use App\Repository\BuildingProgressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AppAssert;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=BuildingProgressRepository::class)
 * @AppAssert\BuildingProgressConstraint
 */
class BuildingProgress
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var BuildingProgressItem[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\BuildingProgressItem", mappedBy="progress", cascade={"persist", "remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return BuildingProgress
     */
    public function setDate(?DateTime $date): BuildingProgress
    {
        $this->date = $date;
        return $this;
    }

    public function getDateWithMonth(){
        $result = "";
        $months = [
            "",
            "январь",
            "февраль",
            "март",
            "апрель",
            "май",
            "июнь",
            "июль",
            "август",
            "сентябрь",
            "октябрь",
            "ноябрь",
            "декабрь",
        ];
        if($this->date){
            $result = $months[$this->date->format('n')] . " " . $this->date->format('Y');
        }
        return $result;
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
     * @return BuildingProgress
     */
    public function setDescription(?string $description): BuildingProgress
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection|BuildingProgressItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(BuildingProgressItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setProgress($this);
        }

        return $this;
    }

    public function removeItem(BuildingProgressItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getProgress() === $this) {
                $item->setProgress(null);
            }
        }

        return $this;
    }
}
