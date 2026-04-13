<?php


namespace App\Command;


use App\Entity\Flat;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateFlatCommand extends Command
{
    protected static $defaultName = 'app:updateFlat';
    protected static $defaultDescription = '';

    private $dataDir;

    private $em;

    public function __construct(EntityManagerInterface $em, string $projectDir, string $name = null)
    {
        $this->em = $em;
        $this->dataDir = $projectDir . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "import" . DIRECTORY_SEPARATOR;

        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->parseFlats();
        /** @var Flat[] $flats */
        $flats = $this->em->getRepository(Flat::class)->findAll();
        foreach ($flats as $flat){
            if(isset($data[$flat->getNumber()])){
                $d = $data[$flat->getNumber()];
                $flat->setPrice($d['price'])->setPriceM($d['priceM']);
            }
        }
        $this->em->flush();

        return Command::SUCCESS;
    }

    protected function parseFlats(){
        $filename = $this->dataDir . "flats.csv";
        $fh = fopen($filename, 'r');
        $data = [];
        if($fh !== false){
            while(($row = fgetcsv($fh)) !== false){
                $data[(int)$this->numeric($row[0])] = [
                    'priceM' => (int)$this->numeric($row[2]),
                    'price' => (int)$this->numeric($row[3]),
                ];
            }
        }
        fclose($fh);

        return $data;
    }

    protected function numeric($string){
        return str_replace([",", " ", " "], [".", "", ""], $string);
    }
}