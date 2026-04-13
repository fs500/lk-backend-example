<?php

namespace App\Entity;

use App\Repository\FloorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=FloorRepository::class)
 * @Vich\Uploadable
 */
class Floor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $number;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $plan;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="plan")
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
    private $planFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $miniPlan;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="miniPlan")
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
    private $miniPlanFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var Flat[]|ArrayCollection
     * @ORM\OneToMany(targetEntity=Flat::class, mappedBy="floor", cascade={"persist","remove"})
     */
    private $flats;

    public function __construct()
    {
        $this->flats = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->number;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     * @return Floor
     */
    public function setNumber(?int $number): Floor
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlan(): ?string
    {
        return $this->plan;
    }

    /**
     * @param string|null $plan
     * @return Floor
     */
    public function setPlan(?string $plan): Floor
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPlanFile(): ?File
    {
        return $this->planFile;
    }

    /**
     * @param File|null $planFile
     * @return Floor
     */
    public function setPlanFile(?File $planFile): Floor
    {
        $this->planFile = $planFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMiniPlan(): ?string
    {
        return $this->miniPlan;
    }

    /**
     * @param string|null $plan
     * @return Floor
     */
    public function setMiniPlan(?string $plan): Floor
    {
        $this->miniPlan = $plan;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getMiniPlanFile(): ?File
    {
        return $this->miniPlanFile;
    }

    /**
     * @param File|null $planFile
     * @return Floor
     */
    public function setMiniPlanFile(?File $planFile): Floor
    {
        $this->miniPlanFile = $planFile;
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

    protected function updateDate(){
        $this->uploadDate = new DateTime();
    }

    /**
     * @return Collection|Flat[]
     */
    public function getFlats(): Collection
    {
        return $this->flats;
    }

    public function addFlat(Flat $flat): self
    {
        if (!$this->flats->contains($flat)) {
            $this->flats[] = $flat;
            $flat->setFloor($this);
        }

        return $this;
    }

    public function removeFlat(Flat $flat): self
    {
        if ($this->flats->removeElement($flat)) {
            // set the owning side to null (unless already changed)
            if ($flat->getFloor() === $this) {
                $flat->setFloor(null);
            }
        }

        return $this;
    }
}
