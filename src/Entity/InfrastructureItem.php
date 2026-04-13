<?php

namespace App\Entity;

use App\Repository\InfrastructureItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InfrastructureItemRepository::class)
 */
class InfrastructureItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Infrastructure|null
     * @ORM\ManyToOne(targetEntity=Infrastructure::class, inversedBy="items")
     */
    private $infrastructure;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $longitude;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfrastructure(): ?Infrastructure
    {
        return $this->infrastructure;
    }

    public function setInfrastructure(?Infrastructure $infrastructure): self
    {
        $this->infrastructure = $infrastructure;

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
     * @return InfrastructureItem
     */
    public function setName(?string $name): InfrastructureItem
    {
        $this->name = $name;
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
     * @return InfrastructureItem
     */
    public function setDescription(?string $description): InfrastructureItem
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return InfrastructureItem
     */
    public function setAddress(?string $address): InfrastructureItem
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     * @return InfrastructureItem
     */
    public function setLatitude(?float $latitude): InfrastructureItem
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     * @return InfrastructureItem
     */
    public function setLongitude(?float $longitude): InfrastructureItem
    {
        $this->longitude = $longitude;
        return $this;
    }

}
