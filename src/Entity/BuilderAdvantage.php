<?php

namespace App\Entity;

use App\Repository\BuilderAdvantageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuilderAdvantageRepository::class)
 */
class BuilderAdvantage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Builder::class, inversedBy="advantages")
     */
    private $builder;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $subHeader;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuilder(): ?Builder
    {
        return $this->builder;
    }

    public function setBuilder(?Builder $builder): self
    {
        $this->builder = $builder;

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
     * @return BuilderAdvantage
     */
    public function setHeader(?string $header): BuilderAdvantage
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubHeader(): ?string
    {
        return $this->subHeader;
    }

    /**
     * @param string|null $subHeader
     * @return BuilderAdvantage
     */
    public function setSubHeader(?string $subHeader): BuilderAdvantage
    {
        $this->subHeader = $subHeader;
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
     * @return BuilderAdvantage
     */
    public function setSort(?int $sort): BuilderAdvantage
    {
        $this->sort = $sort;
        return $this;
    }
}
