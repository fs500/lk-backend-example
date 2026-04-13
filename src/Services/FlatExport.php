<?php


namespace App\Services;


use App\Entity\Flat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FlatExport
{

    /**
     * @param Flat[] $flats
     * @return false|string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function xlsx($flats){
        $data = $this->getArrayData($flats);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultColumnDimension()->setWidth(18);
        $sheet
            ->setTitle('Квартиры от ' . date('d.m.Y'))
            ->fromArray($data)
        ;

        $writer = new Xlsx($spreadsheet);

        $fileName = $this->getXlsFilename();
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($temp_file);

        return $temp_file;
    }

    public function getXlsFilename(){
        return 'flats_' . date('Y-m-d') . '.xlsx';
    }

    /**
     * @param Flat[] $flats
     * @return \string[][]
     */
    protected function getArrayData($flats){
        $result = [
            [
                'Номер',
                'Этаж',
                'Комнатность',
                'Статус',
                'Площадь',
                'Площадь кухни',
                'Площадь комнат',
                'Цена',
                'Цена за кв. м.',
            ]
        ];

        foreach ($flats as $flat){
            $result[] = [
                $flat->getNumber(),
                $flat->getFloor() ? $flat->getFloor()->getNumber() : null,
                $flat->getRoomsHeader(),
                $flat->getStatusHeader(),
                $flat->getArea(),
                $flat->getKitchenArea(),
                $flat->getRoomsArea(),
                $flat->getPrice(),
                $flat->getPriceM()
            ];
        }

        return $result;
    }
}