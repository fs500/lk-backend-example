<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SettingRepository::class)
 * @Vich\Uploadable
 */
class Setting
{
    const TYPE_NUMERIC = "numeric";
    const TYPE_TEXT = "text";
    const TYPE_SCRIPT = "script";
    const TYPE_URL = "url";
    const TYPE_FILE = "file";
    const TYPE_STRING = "string";
    const TYPE_PASSWORD = "password";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var SettingGroup|null
     * @ORM\ManyToOne(targetEntity="SettingGroup", inversedBy="settings")
     */
    private $group;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $file;

    /**
     * @Vich\UploadableField(mapping="setting", fileNameProperty="file")
     * @var UploadedFile|null
     */
    private $uploadedFile;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $uploaded;

    public function __toString()
    {
        return $this->header;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return SettingGroup|null
     */
    public function getGroup(): ?SettingGroup
    {
        return $this->group;
    }

    /**
     * @param SettingGroup|null $group
     * @return Setting
     */
    public function setGroup(?SettingGroup $group): Setting
    {
        $this->group = $group;
        return $this;
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
     * @return Setting
     */
    public function setName(?string $name): Setting
    {
        $this->name = $name;
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
     * @return Setting
     */
    public function setHeader(?string $header): Setting
    {
        $this->header = $header;
        return $this;
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
     * @return Setting
     */
    public function setType(?string $type): Setting
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return Setting
     */
    public function setValue(?string $value): Setting
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     * @return Setting
     */
    public function setNote(?string $note): Setting
    {
        $this->note = $note;
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
     * @return Setting
     */
    public function setFile(?string $file): Setting
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getUploadedFile(): ?File
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile|null $uploadedFile
     * @return Setting
     */
    public function setUploadedFile(?File $uploadedFile): Setting
    {
        $this->uploadedFile = $uploadedFile;
        $this->uploaded = new DateTime();
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUploaded(): DateTime
    {
        return $this->uploaded;
    }

}
