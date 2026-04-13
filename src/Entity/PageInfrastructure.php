<?php

namespace App\Entity;

use App\Repository\PageInfrastructureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageInfrastructureRepository::class)
 */
class PageInfrastructure
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
     */
    private $header1;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header2;

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

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scale;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getHeader1(): ?string
    {
        return $this->header1;
    }

    /**
     * @param string|null $header1
     * @return PageInfrastructure
     */
    public function setHeader1(?string $header1): PageInfrastructure
    {
        $this->header1 = $header1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeader2(): ?string
    {
        return $this->header2;
    }

    /**
     * @param string|null $header2
     * @return PageInfrastructure
     */
    public function setHeader2(?string $header2): PageInfrastructure
    {
        $this->header2 = $header2;
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
     * @return PageInfrastructure
     */
    public function setLatitude(?float $latitude): PageInfrastructure
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
     * @return PageInfrastructure
     */
    public function setLongitude(?float $longitude): PageInfrastructure
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getScale(): ?int
    {
        return $this->scale;
    }

    /**
     * @param int|null $scale
     * @return PageInfrastructure
     */
    public function setScale(?int $scale): PageInfrastructure
    {
        $this->scale = $scale;
        return $this;
    }

}
