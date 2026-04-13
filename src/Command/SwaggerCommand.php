<?php


namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SwaggerCommand extends Command
{
    protected static $defaultName = 'swagger:generate';

    /**
     * @var string
     */
    protected $projectDir;

    public function __construct(string $projectDir, string $name = null)
    {
        $this->projectDir = $projectDir;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $filename = $this->projectDir . DIRECTORY_SEPARATOR ."swagger.yaml";
        $scanDir = $this->projectDir . DIRECTORY_SEPARATOR . "src";
        $openapi = \OpenApi\scan($scanDir);
        $fh = fopen($filename, 'w+');
        fwrite($fh, $openapi->toYaml());
        fclose($fh);
        return self::SUCCESS;
    }
}