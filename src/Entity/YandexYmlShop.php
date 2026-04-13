<?php

namespace App\Entity;

use App\Repository\YandexYmlShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Eyetronic\YandexBuildingYml\Objects\Offer;

/**
 * @ORM\Entity(repositoryClass=YandexYmlShopRepository::class)
 */
class YandexYmlShop
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
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    private $url;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $company;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=YandexYmlSet::class, mappedBy="shop", orphanRemoval=true)
     */
    private $sets;

    /**
     * @ORM\OneToMany(targetEntity=YandexYmlOffer::class, mappedBy="shop")
     */
    private $offers;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $paramConversion;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $paramOfferType;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vendor;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $paramBuilderUrl;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=4, scale=2, nullable=true)
     */
    private $paramMinMortgage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $paramEstateType;

    /**
     * @var array|null
     * @ORM\Column(type="array")
     */
    private $paramEstateClass = [];

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paramAddress;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $paramLatitude;

    /**
     * @var float|null
     * @ORM\Column(type="decimal", precision=15, scale=6, nullable=true)
     */
    private $paramLongitude;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paramBuiltYear;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paramTotalFloor;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paramSubwayDistance;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paramSubwayDistanceUnit;

    /**
     * @var string[]|null
     * @ORM\Column(type="array")
     */
    private $paramParkingType = [];

    /**
     * @var string[]|null
     * @ORM\Column(type="array")
     */
    private $paramFinishing = [];

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paramRepair;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paramSite;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paramPhone;

    /**
     * @ORM\ManyToOne(targetEntity=YandexYmlCurrency::class)
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity=YandexYmlCategory::class, mappedBy="shop")
     */
    private $categories;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * @return YandexYmlShop
     */
    public function setName(?string $name): YandexYmlShop
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return YandexYmlShop
     */
    public function setUrl(?string $url): YandexYmlShop
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     * @return YandexYmlShop
     */
    public function setCompany(?string $company): YandexYmlShop
    {
        $this->company = $company;
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
     * @return YandexYmlShop
     */
    public function setEmail(?string $email): YandexYmlShop
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Collection|YandexYmlSet[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(YandexYmlSet $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
            $set->setShop($this);
        }

        return $this;
    }

    public function removeSet(YandexYmlSet $set): self
    {
        if ($this->sets->removeElement($set)) {
            // set the owning side to null (unless already changed)
            if ($set->getShop() === $this) {
                $set->setShop(null);
            }
        }

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
            $offer->setShop($this);
        }

        return $this;
    }

    public function removeOffer(YandexYmlOffer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getShop() === $this) {
                $offer->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getParamConversion(): ?int
    {
        return $this->paramConversion;
    }

    /**
     * @param int|null $paramConversion
     * @return YandexYmlShop
     */
    public function setParamConversion(?int $paramConversion): YandexYmlShop
    {
        $this->paramConversion = $paramConversion;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParamOfferType(): ?string
    {
        return $this->paramOfferType;
    }

    /**
     * @param string|null $paramOfferType
     * @return YandexYmlShop
     */
    public function setParamOfferType(?string $paramOfferType): YandexYmlShop
    {
        $this->paramOfferType = $paramOfferType;
        return $this;
    }

    public static function getOfferTypeChoices(){
        return [
            Offer::PARAM_OFFER_TYPE_SALE => "Продажа",
            Offer::PARAM_OFFER_TYPE_RENT => "Аренда",
        ];
    }

    /**
     * @return string|null
     */
    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    /**
     * @param string|null $vendor
     * @return YandexYmlShop
     */
    public function setVendor(?string $vendor): YandexYmlShop
    {
        $this->vendor = $vendor;
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
     * @return YandexYmlShop
     */
    public function setDescription(?string $description): YandexYmlShop
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParamBuilderUrl(): ?string
    {
        return $this->paramBuilderUrl;
    }

    /**
     * @param string|null $paramBuilderUrl
     * @return YandexYmlShop
     */
    public function setParamBuilderUrl(?string $paramBuilderUrl): YandexYmlShop
    {
        $this->paramBuilderUrl = $paramBuilderUrl;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getParamMinMortgage(): ?float
    {
        return $this->paramMinMortgage;
    }

    /**
     * @param float|null $paramMinMortgage
     * @return YandexYmlShop
     */
    public function setParamMinMortgage(?float $paramMinMortgage): YandexYmlShop
    {
        $this->paramMinMortgage = $paramMinMortgage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParamEstateType(): ?string
    {
        return $this->paramEstateType;
    }

    /**
     * @param string|null $paramEstateType
     * @return YandexYmlShop
     */
    public function setParamEstateType(?string $paramEstateType): YandexYmlShop
    {
        $this->paramEstateType = $paramEstateType;
        return $this;
    }

    public static function getEstateTypeChoices(){
        return [
            Offer::PARAM_ESTATE_TYPE_PRIMARY => "Первичный",
            Offer::PARAM_ESTATE_TYPE_SECONDARY => "Вторичный",
        ];
    }

    /**
     * @return array|null
     */
    public function getParamEstateClass(): ?array
    {
        return $this->paramEstateClass;
    }

    /**
     * @param array|null $paramEstateClass
     * @return YandexYmlShop
     */
    public function setParamEstateClass(?array $paramEstateClass): YandexYmlShop
    {
        $this->paramEstateClass = $paramEstateClass;
        return $this;
    }

    public static function getEstateClassChoices(){
        return [
            Offer::PARAM_ESTATE_CLASS_ECONOMY => "Эконом",
            Offer::PARAM_ESTATE_CLASS_BUSINESS => "Бизнес",
            Offer::PARAM_ESTATE_CLASS_ELITE => "Элитный",
            Offer::PARAM_ESTATE_CLASS_COMFORT => "Комфорт",
            Offer::PARAM_ESTATE_CLASS_COMFORT_PLUS => "Комфорт+",
            Offer::PARAM_ESTATE_CLASS_PREMIUM => "Премиум",
        ];
    }

    /**
     * @return string|null
     */
    public function getParamAddress(): ?string
    {
        return $this->paramAddress;
    }

    /**
     * @param string|null $paramAddress
     * @return YandexYmlShop
     */
    public function setParamAddress(?string $paramAddress): YandexYmlShop
    {
        $this->paramAddress = $paramAddress;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getParamLatitude(): ?float
    {
        return $this->paramLatitude;
    }

    /**
     * @param float|null $paramLatitude
     * @return YandexYmlShop
     */
    public function setParamLatitude(?float $paramLatitude): YandexYmlShop
    {
        $this->paramLatitude = $paramLatitude;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getParamLongitude(): ?float
    {
        return $this->paramLongitude;
    }

    /**
     * @param float|null $paramLongitude
     * @return YandexYmlShop
     */
    public function setParamLongitude(?float $paramLongitude): YandexYmlShop
    {
        $this->paramLongitude = $paramLongitude;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParamBuiltYear(): ?int
    {
        return $this->paramBuiltYear;
    }

    /**
     * @param int|null $paramBuiltYear
     * @return YandexYmlShop
     */
    public function setParamBuiltYear(?int $paramBuiltYear): YandexYmlShop
    {
        $this->paramBuiltYear = $paramBuiltYear;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParamTotalFloor(): ?int
    {
        return $this->paramTotalFloor;
    }

    /**
     * @param int|null $paramTotalFloor
     * @return YandexYmlShop
     */
    public function setParamTotalFloor(?int $paramTotalFloor): YandexYmlShop
    {
        $this->paramTotalFloor = $paramTotalFloor;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParamSubwayDistance(): ?int
    {
        return $this->paramSubwayDistance;
    }

    /**
     * @param int|null $paramSubwayDistance
     * @return YandexYmlShop
     */
    public function setParamSubwayDistance(?int $paramSubwayDistance): YandexYmlShop
    {
        $this->paramSubwayDistance = $paramSubwayDistance;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParamSubwayDistanceUnit(): ?string
    {
        return $this->paramSubwayDistanceUnit;
    }

    /**
     * @param string|null $paramSubwayDistanceUnit
     * @return YandexYmlShop
     */
    public function setParamSubwayDistanceUnit(?string $paramSubwayDistanceUnit): YandexYmlShop
    {
        $this->paramSubwayDistanceUnit = $paramSubwayDistanceUnit;
        return $this;
    }

    public static function getSubwayDistanceUnitChoices(){
        return [
            Offer::PARAM_SUBWAY_DISTANCE_UNIT_WALK => "Пешком",
            Offer::PARAM_SUBWAY_DISTANCE_UNIT_TRANSPORT => "На транспорте",
        ];
    }

    /**
     * @return string[]|null
     */
    public function getParamParkingType(): ?array
    {
        return $this->paramParkingType;
    }

    /**
     * @param string[]|null $paramParkingType
     * @return YandexYmlShop
     */
    public function setParamParkingType(?array $paramParkingType): YandexYmlShop
    {
        $this->paramParkingType = $paramParkingType;
        return $this;
    }

    public static function getParkingTypeChoices(){
        return [
            Offer::PARAM_PARKING_TYPE_SEPARATE => "Отдельная",
            Offer::PARAM_PARKING_TYPE_GUARDED => "Охраняемая",
            Offer::PARAM_PARKING_TYPE_NEARBY => "Рядом",
            Offer::PARAM_PARKING_TYPE_UNDERGROUND => "Подземная",
            Offer::PARAM_PARKING_TYPE_MULTILEVEL => "Многоуровневая",
            Offer::PARAM_PARKING_TYPE_GROUND => "Наземная",
            Offer::PARAM_PARKING_TYPE_OPEN => "Открытая",
            Offer::PARAM_PARKING_TYPE_PRIVATE => "Закрытая",
        ];
    }

    /**
     * @return string[]|null
     */
    public function getParamFinishing(): ?array
    {
        return $this->paramFinishing;
    }

    /**
     * @param string[]|null $paramFinishing
     * @return YandexYmlShop
     */
    public function setParamFinishing(?array $paramFinishing): YandexYmlShop
    {
        $this->paramFinishing = $paramFinishing;
        return $this;
    }

    public static function getFinishingChoices(){
        return [
            Offer::PARAM_FINISHING_ROUGH => "Черновая",
            Offer::PARAM_FINISHING_FINISHING => "Чистовая",
            Offer::PARAM_FINISHING_FULL => "Под ключ",
        ];
    }

    /**
     * @return string|null
     */
    public function getParamRepair(): ?string
    {
        return $this->paramRepair;
    }

    /**
     * @param string|null $paramRepair
     * @return YandexYmlShop
     */
    public function setParamRepair(?string $paramRepair): YandexYmlShop
    {
        $this->paramRepair = $paramRepair;
        return $this;
    }

    public static function getRepairChoices(){
        return [
            Offer::PARAM_REPAIR_REDECORATING => "Косметический",
            Offer::PARAM_REPAIR_EURO => "Евро",
            Offer::PARAM_REPAIR_DESIGN => "Дизайнерский",
            Offer::PARAM_REPAIR_REQUIRED => "Требуется",
        ];
    }

    /**
     * @return string|null
     */
    public function getParamSite(): ?string
    {
        return $this->paramSite;
    }

    /**
     * @param string|null $paramSite
     * @return YandexYmlShop
     */
    public function setParamSite(?string $paramSite): YandexYmlShop
    {
        $this->paramSite = $paramSite;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getParamPhone(): ?string
    {
        return $this->paramPhone;
    }

    /**
     * @param string|null $paramPhone
     * @return YandexYmlShop
     */
    public function setParamPhone(?string $paramPhone): YandexYmlShop
    {
        $this->paramPhone = $paramPhone;
        return $this;
    }

    public function getCurrency(): ?YandexYmlCurrency
    {
        return $this->currency;
    }

    public function setCurrency(?YandexYmlCurrency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection|YandexYmlCategory[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(YandexYmlCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setShop($this);
        }

        return $this;
    }

    public function removeCategory(YandexYmlCategory $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getShop() === $this) {
                $category->setShop(null);
            }
        }

        return $this;
    }
}
