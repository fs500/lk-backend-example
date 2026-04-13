<?php

namespace App\Entity;

use App\Repository\BuilderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=BuilderRepository::class)
 * @Vich\Uploadable
 */
class Builder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $logo;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="logo")
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
    private $logoFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @ORM\OneToMany(targetEntity=BuilderAdvantage::class, mappedBy="builder", cascade={"persist","remove"})
     */
    private $advantages;

    public function __construct()
    {
        $this->advantages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     * @return $this
     */
    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    /**
     * @param File|null $logoFile
     * @return $this
     */
    public function setLogoFile(?File $logoFile): self
    {
        $this->logoFile = $logoFile;
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

    /**
     * @return $this
     */
    public function updateDate(){
        $this->uploadDate = new DateTime();
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
     * @return Builder
     */
    public function setHeader(?string $header): Builder
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return Builder
     */
    public function setText(?string $text): Builder
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Collection|BuilderAdvantage[]
     */
    public function getAdvantages(): Collection
    {
        return $this->advantages;
    }

    public function addAdvantage(BuilderAdvantage $advantage): self
    {
        if (!$this->advantages->contains($advantage)) {
            $this->advantages[] = $advantage;
            $advantage->setBuilder($this);
        }

        return $this;
    }

    public function removeAdvantage(BuilderAdvantage $advantage): self
    {
        if ($this->advantages->removeElement($advantage)) {
            // set the owning side to null (unless already changed)
            if ($advantage->getBuilder() === $this) {
                $advantage->setBuilder(null);
            }
        }

        return $this;
    }

}
