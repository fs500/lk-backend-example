<?php


namespace App\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class UpdateFlat
 * @package App\Entity\Form
 * @Vich\Uploadable
 */
class UpdateFlat
{
    /**
     * @var string|null
     */
    private $data;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="data")
     * @var File|null
     * @Assert\File(
     *      mimeTypes = {
     *          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *          "application/vnd.ms-excel"
     *      },
     *      mimeTypesMessage = "Неверный формат файла. Разрешенный формат: xlsx"
     * )
     */
    private $dataFile;

    /**
     * @var DateTime|null
     */
    private $uploadDate;

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @param string|null $data
     */
    public function setData(?string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return File|null
     */
    public function getDataFile(): ?File
    {
        return $this->dataFile;
    }

    /**
     * @param File|null $dataFile
     */
    public function setDataFile(?File $dataFile): void
    {
        $this->dataFile = $dataFile;
        $this->updateDate();
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
}