<?php

namespace App\Entity;

use App\Repository\ContactsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=ContactsRepository::class)
 * @Vich\Uploadable
 */
class Contacts
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
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subHeader;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $mapLatitude;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $mapLongitude;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mapScale;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $officeAddress;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $officeImage;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="officeImage")
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
    private $officeImageFile;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $officeLatitude;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $officeLongitude;

    /**
     * @var Link|null
     * @ORM\ManyToOne(targetEntity=Link::class, cascade={"persist", "remove"}, fetch="EAGER")
     * @Assert\Valid()
     */
    private $officeRoute;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $objectAddress;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objectImage;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="objectImage")
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
    private $objectImageFile;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $objectLatitude;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $objectLongitude;

    /**
     * @var Link|null
     * @ORM\ManyToOne(targetEntity=Link::class, cascade={"persist", "remove"}, fetch="EAGER")
     * @Assert\Valid()
     */
    private $objectRoute;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site;

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
    public function getHeader(): ?string
    {
        return $this->header;
    }

    /**
     * @param string|null $header
     * @return Contacts
     */
    public function setHeader(?string $header): Contacts
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
     * @return Contacts
     */
    public function setSubHeader(?string $subHeader): Contacts
    {
        $this->subHeader = $subHeader;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMapLatitude(): ?float
    {
        return $this->mapLatitude;
    }

    /**
     * @param float|null $mapLatitude
     * @return Contacts
     */
    public function setMapLatitude(?float $mapLatitude): Contacts
    {
        $this->mapLatitude = $mapLatitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMapLongitude(): ?float
    {
        return $this->mapLongitude;
    }

    /**
     * @param float|null $mapLongitude
     * @return Contacts
     */
    public function setMapLongitude(?float $mapLongitude): Contacts
    {
        $this->mapLongitude = $mapLongitude;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMapScale(): ?int
    {
        return $this->mapScale;
    }

    /**
     * @param int|null $mapScale
     * @return Contacts
     */
    public function setMapScale(?int $mapScale): Contacts
    {
        $this->mapScale = $mapScale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOfficeAddress(): ?string
    {
        return $this->officeAddress;
    }

    /**
     * @param string|null $officeAddress
     * @return Contacts
     */
    public function setOfficeAddress(?string $officeAddress): Contacts
    {
        $this->officeAddress = $officeAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOfficeImage(): ?string
    {
        return $this->officeImage;
    }

    /**
     * @param string|null $officeImage
     * @return Contacts
     */
    public function setOfficeImage(?string $officeImage): Contacts
    {
        $this->officeImage = $officeImage;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getOfficeImageFile(): ?File
    {
        return $this->officeImageFile;
    }

    /**
     * @param File|null $officeImageFile
     * @return Contacts
     */
    public function setOfficeImageFile(?File $officeImageFile): Contacts
    {
        $this->officeImageFile = $officeImageFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return float|null
     */
    public function getOfficeLatitude(): ?float
    {
        return $this->officeLatitude;
    }

    /**
     * @param float|null $officeLatitude
     * @return Contacts
     */
    public function setOfficeLatitude(?float $officeLatitude): Contacts
    {
        $this->officeLatitude = $officeLatitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getOfficeLongitude(): ?float
    {
        return $this->officeLongitude;
    }

    /**
     * @param float|null $officeLongitude
     * @return Contacts
     */
    public function setOfficeLongitude(?float $officeLongitude): Contacts
    {
        $this->officeLongitude = $officeLongitude;
        return $this;
    }

    /**
     * @return Link|null
     */
    public function getOfficeRoute(): ?Link
    {
        return $this->officeRoute;
    }

    /**
     * @param Link|null $officeRoute
     * @return Contacts
     */
    public function setOfficeRoute(?Link $officeRoute): Contacts
    {
        $this->officeRoute = $officeRoute;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getObjectAddress(): ?string
    {
        return $this->objectAddress;
    }

    /**
     * @param string|null $objectAddress
     * @return Contacts
     */
    public function setObjectAddress(?string $objectAddress): Contacts
    {
        $this->objectAddress = $objectAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getObjectImage(): ?string
    {
        return $this->objectImage;
    }

    /**
     * @param string|null $objectImage
     * @return Contacts
     */
    public function setObjectImage(?string $objectImage): Contacts
    {
        $this->objectImage = $objectImage;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getObjectImageFile(): ?File
    {
        return $this->objectImageFile;
    }

    /**
     * @param File|null $objectImageFile
     * @return Contacts
     */
    public function setObjectImageFile(?File $objectImageFile): Contacts
    {
        $this->objectImageFile = $objectImageFile;
        $this->updateDate();
        return $this;
    }

    /**
     * @return float|null
     */
    public function getObjectLatitude(): ?float
    {
        return $this->objectLatitude;
    }

    /**
     * @param float|null $objectLatitude
     * @return Contacts
     */
    public function setObjectLatitude(?float $objectLatitude): Contacts
    {
        $this->objectLatitude = $objectLatitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getObjectLongitude(): ?float
    {
        return $this->objectLongitude;
    }

    /**
     * @param float|null $objectLongitude
     * @return Contacts
     */
    public function setObjectLongitude(?float $objectLongitude): Contacts
    {
        $this->objectLongitude = $objectLongitude;
        return $this;
    }

    /**
     * @return Link|null
     */
    public function getObjectRoute(): ?Link
    {
        return $this->objectRoute;
    }

    /**
     * @param Link|null $objectRoute
     * @return Contacts
     */
    public function setObjectRoute(?Link $objectRoute): Contacts
    {
        $this->objectRoute = $objectRoute;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return Contacts
     */
    public function setPhone(?string $phone): Contacts
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contacts
     */
    public function setEmail(?string $email): Contacts
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * @param string|null $site
     * @return Contacts
     */
    public function setSite(?string $site): Contacts
    {
        $this->site = $site;
        return $this;
    }

    public function getSiteUrl(){
        $result = null;
        if($this->site){
            $result = "https://" . str_replace(['http://', 'https://'], '', $this->site);
        }
        return $result;
    }

    /**
     * @return DateTime|null
     */
    public function getUploadDate(): ?DateTime
    {
        return $this->uploadDate;
    }

    public function updateDate(){
        $this->uploadDate = new DateTime();
    }

}
