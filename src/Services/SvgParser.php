<?php


namespace App\Services;

use App\Entity\Flat;
use Vich\UploaderBundle\Storage\StorageInterface;

class SvgParser
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function flatPlan(Flat $flat){
        $result = "";
        $filename = $this->storage->resolvePath($flat, 'planFile');
        if($filename && file_exists($filename)){
            if($file = file_get_contents($filename)){
                $result = $file;

                $xml = simplexml_load_string($file);
                if($xml){
                    foreach ($xml as $tag){
                        $attributes = $tag->attributes();
                        if(!isset($attributes['fill'])){
                            $tag->addAttribute('fill', 'white');
                        }
                    }
                    $result = $xml->asXML();
                }
            }
        }

        return $result;
    }

    public function floorPlan(Flat $flat){
        $result = "";
        if($flat->getFloor() && $flat->getFloor()->getPlan()){
            $filename = $this->storage->resolvePath($flat->getFloor(), 'miniPlanFile');
            if($filename && file_exists($filename)){
                if($file = file_get_contents($filename)){
                    $result = $file;
                    $xml = simplexml_load_string($file);
                    if($xml){
                        foreach ($xml as $group){
                            $attributes = $group->attributes();
                            if(!isset($attributes['fill'])){
                                $group->addAttribute('fill', 'white');
                            }
                            foreach ($group as $g){
                                $attributes = $g->attributes();
                                if(isset($attributes['id'])){
                                    $number = $this->getFlatNumber($attributes['id']);
                                    if($number){
                                        if($number != $flat->getNumber()){
                                            $g->addAttribute('fill-opacity', '0.3');
                                            $g->addAttribute('stroke-opacity', '0.3');
                                        }
                                    }
                                }
                            }
                        }
                        $result = $xml->asXML();
                    }
                }
            }
        }

        return $result;
    }

    protected function getFlatNumber($attr){
        $result = null;
        $attr= strtolower($attr);
        $ids = ['apartment_', 'apatment_'];
        foreach ($ids as  $id){
            if(strpos($attr, $id) === 0){
                $result = (int)str_replace($id, "", $attr);
            }
        }

        return $result;
    }
}