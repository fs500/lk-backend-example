<?php


namespace App\Event\EntityListener;


use App\Entity\Flat;
use App\Services\FileUrlHelper;
use App\Services\SVG2PNGConverter;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Vich\UploaderBundle\Storage\StorageInterface;

class FlatPlanConverterListener
{
    /**
     * @var SVG2PNGConverter
     */
    private $converter;

    /**
     * @var StorageInterface
     */
    private $storage;

    public function __construct(SVG2PNGConverter $converter, StorageInterface $storage)
    {
        $this->converter = $converter;
        $this->storage = $storage;
    }

    public function postUpdate(Flat $entity, LifecycleEventArgs $args){
        $em = $args->getEntityManager();
        $this->convert($entity, $em);
    }

    protected function convert(Flat $entity, $em){
        if(
            empty($entity->getConvertedPlan()) &&
            empty($entity->getConvertedPlanFile())
        ){
            if($entity->getPlan()){
                $filename = $this->storage->resolvePath($entity, 'planFile');
                if(file_exists($filename)){
                    $file = $this->converter->scaleAndConvert($entity, 'planFile');
                    if($file){
                        $entity->setConvertedPlan($file->getBasename());
                    }
                    else{
                        $entity->setConvertedPlan(null);
                    }
                    $em->flush();
                }
            }
        }
    }
}