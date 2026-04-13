<?php


namespace App\Services;


use App\Entity\Flat;
use App\Repository\FlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FlatUpdater
{
    const XLS_STATUS_FREE = "свободна";
    const XLS_STATUS_RESERVED = "бронь";
    const XLS_STATUS_SOLD = "продано";
    const XLS_STATUS_CLOSED = "закрыта";
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FlatRepository
     */
    private $flatRepository;

    private $errors = [];

    private $updatedRows = 0;

    public function __construct(EntityManagerInterface $em, FlatRepository $repository)
    {
        $this->em = $em;
        $this->flatRepository = $repository;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getUpdatedRows(): int
    {
        return $this->updatedRows;
    }

    public function fromExcel($filename){
        $this->resetState();
        $result = false;
        if(file_exists($filename)){
            try {
                $data = $this->xlsToArray($filename);
                $flats = $this->getFlatsByNumbers(array_keys($data));
                foreach ($flats as $flat){
                    $flatData = $data[$flat->getNumber()];
                    $flat
                        //->setArea($flatData['totalArea'])
                        ->setPrice($flatData['price'])
                        ->setPriceM($flatData['priceM'])
                        ->setPriceFinish($flatData['priceFinish'])
                        ->setPriceFinishM($flatData['priceFinishM'])
                        ->setStatus($flatData['status'])
                        ->setPlanUrl($flatData['plan3d'])
                    ;
                    $this->updatedRows++;
                }
                $this->em->flush();
                $result = true;
            } catch (\Exception $e){
                $this->addError(sprintf('Ошибка при разборе файла: %s', $e->getMessage()));
            }
        }
        else{
            $this->addError('Файл не найден');
        }

        return $result;
    }

    /**
     * @param $numbers
     * @return Flat[]
     */
    protected function getFlatsByNumbers($numbers){
        return $this->flatRepository->findBy(['number' => $numbers]);
    }

    protected function xlsToArray($filename){
        $result = [];
        $spreadsheet = IOFactory::load($filename);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null,true,true,false);
        foreach ($data as $d){
            $number = trim($d[0]);
            if(is_numeric($number)){
                $number = (int)$number;
                $status = $this->getStatusFromXls($d[6]);
                if($status){
                    $result[$number] = [
                        'area' => $this->strToFloat($d[1]),
                        'balconyArea' => $this->strToFloat($d[2]),
                        'totalArea' => $this->strToFloat($d[3]),
                        'priceM' => $this->strToInt($d[4]),
                        'price' => $this->strToInt($d[5]),
                        'status' => $status,
                        'priceFinishM' => $this->strToInt($d[7]),
                        'priceFinish' => $this->strToInt($d[8]),
                        'plan3d' => empty(trim($d[9])) ? null : trim($d[9]),
                    ];
                }
                else{
                    $this->addError(sprintf("Не определен статус для квартиры № %s", $number));
                }
            }
        }

        return $result;
    }

    protected function getStatusFromXls($status){
        switch (trim($status)){
            case self::XLS_STATUS_FREE:
                $result = Flat::STATUS_FREE;
                break;
            case self::XLS_STATUS_RESERVED:
                $result = Flat::STATUS_RESERVED;
                break;
            case self::XLS_STATUS_SOLD:
                $result = Flat::STATUS_SOLD;
                break;
            case self::XLS_STATUS_CLOSED:
                $result = Flat::STATUS_CLOSED;
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }

    protected function strToInt($string){
        return empty(trim($string)) ? null : (int)mb_eregi_replace('[^0-9\.]', '', $string);
    }

    protected function strToFloat($string){
        return empty(trim($string)) ? null : (float)mb_eregi_replace('[^0-9\.]', '', str_replace(',', '.', $string));
    }

    protected function addError($msg){
        $this->errors[] = $msg;
    }

    protected function resetState(){
        $this->errors = [];
        $this->updatedRows = 0;
    }
}