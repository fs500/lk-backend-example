<?php

namespace App\Entity;

use App\Repository\BankRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=BankRepository::class)
 * @Vich\Uploadable
 */
class Bank
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
     * @var integer|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

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
     * @return Bank
     */
    public function setHeader(?string $header): Bank
    {
        $this->header = $header;
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
     * @return Bank
     */
    public function setSort(?int $sort): Bank
    {
        $this->sort = $sort;
        return $this;
    }
}
