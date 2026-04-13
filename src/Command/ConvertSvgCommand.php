<?php


namespace App\Command;


use App\Repository\FlatRepository;
use App\Services\SVG2PNGConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertSvgCommand extends Command
{

    protected static $defaultName = 'app:flat:convert';

    /**
     * @var SVG2PNGConverter
     */
    private $converter;

    /**
     * @var FlatRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        SVG2PNGConverter $converter,
        FlatRepository $repository,
        EntityManagerInterface $em,
        string $name = null
    )
    {
        $this->converter = $converter;
        $this->repository = $repository;
        $this->em = $em;
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $flats = $this->repository->findAll();
        foreach ($flats as $flat){
            $file = $this->converter->scaleAndConvert($flat, 'planFile');
            if($file){
                $flat->setConvertedPlan($file->getBasename());
            }
            else{
                $flat->setConvertedPlan(null);
            }
        }
        $this->em->flush();
        return self::SUCCESS;
    }
}