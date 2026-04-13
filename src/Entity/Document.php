<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @Vich\Uploadable
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime|null
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $type;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $size;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @Vich\UploadableField(mapping="files", fileNameProperty="file")
     * @Assert\File(
     *      mimeTypes = {
     *          "application/pdf",
     *          "application/msword",
     *          "application/vnd.ms-excel",
     *          "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: PDF, Word, Excel"
     * )
     * @var File|null
     */
    private $uploadedFile;

    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadedDate;

    /**
     * @Assert\Callback()
     * @param ExecutionContextInterface $context
     */
    public function validateFile(ExecutionContextInterface $context)
    {
        if (!$this->file && !$this->uploadedFile) {
            $context->buildViolation("Загрузите файл")
                ->atPath("uploadedFile")
                ->addViolation();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date
     * @return Document
     */
    public function setDate(?DateTime $date): Document
    {
        $this->date = $date;
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
     * @return Document
     */
    public function setType(?string $type): Document
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return Document
     */
    public function setSize(?int $size): Document
    {
        $this->size = $size;
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
     * @return Document
     */
    public function setName(?string $name): Document
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
     * @return Document
     */
    public function setHeader(?string $header): Document
    {
        $this->header = $header;
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
     * @return Document
     */
    public function setFile(?string $file): Document
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUploadedDate(): ?DateTime
    {
        return $this->uploadedDate;
    }

    /**
     * @return Document
     */
    public function updateDate(): Document
    {
        $this->uploadedDate = new DateTime();
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
     * @return Document
     */
    public function setUploadedFile(?File $uploadedFile): Document
    {
        $this->uploadedFile = $uploadedFile;
        $this->updateDate();
        $this->updateFileInfo();
        return $this;
    }

    protected function updateFileInfo(){
        if($this->uploadedFile instanceof File){
            $this->size = $this->uploadedFile->getSize();
            $this->type = $this->uploadedFile->getExtension();
        }
        return $this;
    }

}
