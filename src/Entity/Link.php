<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 * @Vich\Uploadable
 */
class Link
{
    const TYPE_URL = 'url';
    const TYPE_FILE = 'file';
    const TYPE_PAGE = 'page';
    const TYPE_FLATS_VISUAL = 'flats_visual';
    const TYPE_FLATS_PARAMETER = "flats_parameter";
    const TYPE_LIVE_BROADCAST = "live_broadcast";
    const TYPE_NEWS_LIST = 'news_list';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * Страница на которую ссылается ссылка.
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $page;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @Vich\UploadableField(mapping="files", fileNameProperty="file")
     * @var File|null
     */
    private $uploadedFile;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadDate;

    /**
     * @var bool|null
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $popup = false;

    /**
     * @Assert\Callback()
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if(!is_null($this->type)){
            if(empty($this->header)){
                $context
                    ->buildViolation("Укажите текст ссылки")
                    ->atPath('header')
                    ->addViolation()
                ;
            }
            switch ($this->type){
                case self::TYPE_URL:
                    if(empty($this->url)){
                        $context
                            ->buildViolation("Укажите URL")
                            ->atPath('url')
                            ->addViolation()
                        ;
                    }
                    break;
                case self::TYPE_FILE:
                    if(!$this->file && !$this->uploadedFile){
                        $context
                            ->buildViolation("Загрузите файл")
                            ->atPath('uploadedFile')
                            ->addViolation()
                        ;
                    }
                    break;
                case self::TYPE_PAGE:
                    if(!$this->page){
                        $context
                            ->buildViolation("Выберите страницу")
                            ->atPath('header')
                            ->addViolation()
                        ;
                    }
                    break;
            }
        }
    }

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
     * @return Link
     */
    public function setType(?string $type): Link
    {
        $this->type = $type;
        return $this;
    }

    public static function typeChoices(){
        return [
            self::TYPE_PAGE => 'Страница сайта',
            self::TYPE_NEWS_LIST => 'Новости',
            self::TYPE_URL => 'Произвольный URL',
            self::TYPE_FILE => 'Загрузить файл',
            self::TYPE_FLATS_VISUAL => 'Визуальный выборщик',
            self::TYPE_FLATS_PARAMETER => 'Выбор по параметрам',
            self::TYPE_LIVE_BROADCAST => 'Ссылка на трансляцию'
        ];
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
     * @return Link
     */
    public function setHeader(?string $header): Link
    {
        $this->header = $header;
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
     * @return Link
     */
    public function setUrl(?string $url): Link
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPage(): ?string
    {
        return $this->page;
    }

    /**
     * @param string|null $page
     * @return Link
     */
    public function setPage(?string $page): Link
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return News|null
     */
    public function getNews(): ?News
    {
        return $this->news;
    }

    /**
     * @param News|null $news
     * @return Link
     */
    public function setNews(?News $news): Link
    {
        $this->news = $news;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPopup(): ?bool
    {
        return $this->popup;
    }

    /**
     * @param bool|null $popup
     * @return Link
     */
    public function setPopup(?bool $popup): Link
    {
        $this->popup = $popup;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param string|null $file
     * @return Link
     */
    public function setFile(?string $file): Link
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getUploadedFile(): ?File
    {
        return $this->uploadedFile;
    }

    /**
     * @param File|null $uploadedFile
     * @return Link
     */
    public function setUploadedFile(?File $uploadedFile): Link
    {
        $this->uploadedFile = $uploadedFile;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUploadDate(): DateTime
    {
        return $this->uploadDate;
    }

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function updateDate()
    {
        $this->uploadDate = new DateTime('now');
    }
}
