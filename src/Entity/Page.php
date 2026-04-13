<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;


/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @Vich\Uploadable
 */
class Page
{
    const TYPE_INDEX = "index";
    const TYPE_HOW_TO_BUY = "how_to_buy";
    const TYPE_BUILDING_PROGRESS = "building_progress";
    const TYPE_DOCUMENTS = "documents";
    const TYPE_COMMERCE = "commerce";
    const TYPE_CONTACTS = "contacts";
    const TYPE_LOCATION = "location";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private $type;

    /**
     * @var PageSlide[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="PageSlide", mappedBy="page", cascade={"persist", "remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $slides;

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
     * @var string|null
     * @ORM\Column(name="image1", type="string", length=50, nullable=true)
     */
    private $image1;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image1")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "image/jpg",
     *          "image/jpeg",
     *          "image/gif",
     *          "image/png"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png"
     * )
     */
    private $imageFile1;

    /**
     * @var string|null
     * @ORM\Column(name="image2", type="string", length=50, nullable=true)
     */
    private $image2;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image2")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "image/jpg",
     *          "image/jpeg",
     *          "image/gif",
     *          "image/png"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png"
     * )
     */
    private $imageFile2;

    /**
     * @var string|null
     * @ORM\Column(name="image3", type="string", length=50, nullable=true)
     */
    private $image3;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image3")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "image/jpg",
     *          "image/jpeg",
     *          "image/gif",
     *          "image/png"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: jpg, gif, png"
     * )
     */
    private $imageFile3;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subHeader1;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subHeader2;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subHeader3;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subHeader4;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subHeader5;

    /**
     * @ORM\OneToMany(targetEntity=PageImage::class, mappedBy="page", cascade={"persist", "remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $images;

    /**
     * @var PageTerms[]|ArrayCollection
     * @ORM\OneToMany(targetEntity=PageTerms::class, mappedBy="page", cascade={"persist","remove"})
     */
    private $terms;

    /**
     * @var PageHowTo[]|ArrayCollection
     * @ORM\OneToMany(targetEntity=PageHowTo::class, mappedBy="page", cascade={"persist","remove"})
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    private $howTos;

    /**
     * @var Link|null
     * @ORM\ManyToOne(targetEntity=Link::class, cascade={"persist", "remove"}, fetch="EAGER")
     * @Assert\Valid()
     */
    private $link;

    /**
     * @var PageHowToReservation[]|ArrayCollection
     * @ORM\OneToMany(targetEntity=PageHowToReservation::class, mappedBy="page", cascade={"persist", "remove"}, fetch="EAGER")
     */
    private $howToReservations;

    public function __construct()
    {
        $this->slides = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->terms = new ArrayCollection();
        $this->howTos = new ArrayCollection();
        $this->howToReservations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Page
     */
    public function setType(?string $type): Page
    {
        $this->type = $type;
        return $this;
    }

    public static function getTypeChoices(){
        return [
            self::TYPE_INDEX => 'Главная страница',
            self::TYPE_HOW_TO_BUY => 'Как купить',
            self::TYPE_BUILDING_PROGRESS => "Ход строительства",
            self::TYPE_LOCATION => 'Расположение',
            self::TYPE_DOCUMENTS => 'Документы',
            self::TYPE_COMMERCE => 'Коммерция',
            self::TYPE_CONTACTS => 'Контакты',
        ];
    }

    /**
     * @return PageSlide[]|ArrayCollection
     */
    public function getSlides()
    {
        return $this->slides;
    }

    /**
     * @param PageSlide $slide
     * @return $this
     */
    public function addSlide(PageSlide $slide): self
    {
        if (!$this->slides->contains($slide)) {
            $this->slides[] = $slide;
            $slide->setPage($this);
        }

        return $this;
    }

    /**
     * @param PageSlide $slide
     * @return $this
     */
    public function removeSlide(PageSlide $slide): self
    {
        if ($this->slides->contains($slide)) {
            $this->slides->removeElement($slide);
            // set the owning side to null (unless already changed)
            if ($slide->getPage() === $this) {
                $slide->setPage(null);
            }
        }

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
     * @return Page
     */
    public function setHeader(?string $header): Page
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
     * @return Page
     */
    public function setText(?string $text): Page
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage1(): ?string
    {
        return $this->image1;
    }

    /**
     * @param string|null $image1
     * @return Page
     */
    public function setImage1(?string $image1): Page
    {
        $this->image1 = $image1;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }

    /**
     * @param File|null $imageFile1
     * @return Page
     */
    public function setImageFile1(?File $imageFile1): Page
    {
        $this->imageFile1 = $imageFile1;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage2(): ?string
    {
        return $this->image2;
    }

    /**
     * @param string|null $image2
     * @return Page
     */
    public function setImage2(?string $image2): Page
    {
        $this->image2 = $image2;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

    /**
     * @param File|null $imageFile2
     * @return Page
     */
    public function setImageFile2(?File $imageFile2): Page
    {
        $this->imageFile2 = $imageFile2;
        $this->updateDate();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage3(): ?string
    {
        return $this->image3;
    }

    /**
     * @param string|null $image3
     * @return Page
     */
    public function setImage3(?string $image3): Page
    {
        $this->image3 = $image3;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile3(): ?File
    {
        return $this->imageFile3;
    }

    /**
     * @param File|null $imageFile
     * @return Page
     */
    public function setImageFile3(?File $imageFile): Page
    {
        $this->imageFile3 = $imageFile;
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
     * @return Page
     */
    protected function updateDate(): Page
    {
        $this->uploadDate = new DateTime();
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubHeader1(): ?string
    {
        return $this->subHeader1;
    }

    /**
     * @param string|null $subHeader1
     * @return Page
     */
    public function setSubHeader1(?string $subHeader1): Page
    {
        $this->subHeader1 = $subHeader1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubHeader2(): ?string
    {
        return $this->subHeader2;
    }

    /**
     * @param string|null $subHeader2
     * @return Page
     */
    public function setSubHeader2(?string $subHeader2): Page
    {
        $this->subHeader2 = $subHeader2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubHeader3(): ?string
    {
        return $this->subHeader3;
    }

    /**
     * @param string|null $subHeader3
     * @return Page
     */
    public function setSubHeader3(?string $subHeader3): Page
    {
        $this->subHeader3 = $subHeader3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubHeader4(): ?string
    {
        return $this->subHeader4;
    }

    /**
     * @param string|null $subHeader4
     * @return Page
     */
    public function setSubHeader4(?string $subHeader4): Page
    {
        $this->subHeader4 = $subHeader4;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubHeader5(): ?string
    {
        return $this->subHeader5;
    }

    /**
     * @param string|null $subHeader5
     * @return Page
     */
    public function setSubHeader5(?string $subHeader5): Page
    {
        $this->subHeader5 = $subHeader5;
        return $this;
    }

    /**
     * @return Collection|PageImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(PageImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPage($this);
        }

        return $this;
    }

    public function removeImage(PageImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPage() === $this) {
                $image->setPage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PageTerms[]
     */
    public function getTerms(): Collection
    {
        return $this->terms;
    }

    public function addTerm(PageTerms $term): self
    {
        if (!$this->terms->contains($term)) {
            $this->terms[] = $term;
            $term->setPage($this);
        }

        return $this;
    }

    public function removeTerm(PageTerms $term): self
    {
        if ($this->terms->removeElement($term)) {
            // set the owning side to null (unless already changed)
            if ($term->getPage() === $this) {
                $term->setPage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PageHowTo[]
     */
    public function getHowTos(): Collection
    {
        return $this->howTos;
    }

    public function addHowTo(PageHowTo $howTo): self
    {
        if (!$this->howTos->contains($howTo)) {
            $this->howTos[] = $howTo;
            $howTo->setPage($this);
        }

        return $this;
    }

    public function removeHowTo(PageHowTo $howTo): self
    {
        if ($this->howTos->removeElement($howTo)) {
            // set the owning side to null (unless already changed)
            if ($howTo->getPage() === $this) {
                $howTo->setPage(null);
            }
        }

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
     * @return Page
     */
    public function setLink(?Link $link): Page
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return Collection|PageHowToReservation[]
     */
    public function getHowToReservations(): Collection
    {
        return $this->howToReservations;
    }

    public function addHowToReservation(PageHowToReservation $howToReservation): self
    {
        if (!$this->howToReservations->contains($howToReservation)) {
            $this->howToReservations[] = $howToReservation;
            $howToReservation->setPage($this);
        }

        return $this;
    }

    public function removeHowToReservation(PageHowToReservation $howToReservation): self
    {
        if ($this->howToReservations->removeElement($howToReservation)) {
            // set the owning side to null (unless already changed)
            if ($howToReservation->getPage() === $this) {
                $howToReservation->setPage(null);
            }
        }

        return $this;
    }
}
