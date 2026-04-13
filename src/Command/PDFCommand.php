<?php


namespace App\Command;


use App\Services\FlatPDFManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\RouterInterface;

class PDFCommand extends Command
{
    protected static $defaultName = 'app:pdf';

    /**
     * @var FlatPDFManager
     */
    private $manager;

    public function __construct(FlatPDFManager $manager, string $name = null)
    {
        $this->manager = $manager;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->manager->renderAll();
        return self::SUCCESS;
    }
}