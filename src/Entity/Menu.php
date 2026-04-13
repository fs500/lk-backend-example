<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $header;

    /**
     * @var Link|null
     * @ORM\ManyToOne(targetEntity=Link::class, cascade={"persist", "remove"}, fetch="EAGER")
     * @Assert\Valid()
     */
    private $link;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

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
     * @return Menu
     */
    public function setHeader(?string $header): Menu
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return Link|null
     */
    public function getLink(): ?Link
    {
        return $this->link;
    }

    /**
     * @param Link|null $link
     * @return Menu
     */
    public function setLink(?Link $link): Menu
    {
        $this->link = $link;
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
     * @return Menu
     */
    public function setSort(?int $sort): Menu
    {
        $this->sort = $sort;
        return $this;
    }

}
