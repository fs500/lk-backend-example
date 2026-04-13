<?php


namespace App\Services;


use Vich\UploaderBundle\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\File\File;
use function PHPUnit\Framework\directoryExists;

class SVG2PNGConverter
{
    /**
     * @var FileUrlHelper
     */
    private $fileUrlHelper;

    /**
     * @var string
     */
    private $convertDir;

    /**
     * @var StorageInterface
     */
    private $storage;

    public function __construct(
        FileUrlHelper $fileUrlHelper,
        StorageInterface $storage,
        string $convertDir
    )
    {
        $this->fileUrlHelper = $fileUrlHelper;
        $this->convertDir = $convertDir;
        $this->storage = $storage;
    }

    /**
     * @param $entity
     * @param $fileAttr
     * @param int $rate
     * @param bool $removeTempFile
     * @return File|null
     */
    public function scaleAndConvert($entity, $fileAttr, $rate = 2, $removeTempFile = true){
        $result = null;
        $filename = $this->storage->resolvePath($entity, $fileAttr);
        $file = new File($filename);
        if($file->getExtension() == "svg"){
            $svg = $this->scaleSVG($entity, $fileAttr, $rate);
            if(!is_null($svg)){
                $result = $this->convert($svg);
                if($removeTempFile){
                    unlink($svg->getRealPath());
                }
            }
        }
        else{
            $convertedFilename = $this->getPngDirPath() . DIRECTORY_SEPARATOR . $file->getBasename();
            copy($file->getRealPath(), $convertedFilename);
            $result = new File($convertedFilename);
        }

        return $result;
    }

    /**
     * @param $entity
     * @param $fileAttr
     * @param int $rate
     * @return File|null
     */
    public function scaleSVG($entity, $fileAttr, $rate = 2){
        $result = null;
        $filename = $this->storage->resolvePath($entity, $fileAttr);

        if($filename && file_exists($filename)){
            $file = new File($filename);
            $dom = new \DOMDocument('1.0', 'utf-8');
            $dom->load($filename);
            $svg = $dom->documentElement;

            $width = $svg->getAttribute('width');
            $height = $svg->getAttribute('height');
            $svg->setAttribute('width', $width * $rate);
            $svg->setAttribute('height', $height * $rate);
            $newFile = $this->getSvgDirPath() . DIRECTORY_SEPARATOR . $file->getBasename();
            $dom->save($newFile);
            $result = new File($newFile);
        }

        return $result;
    }

    public function convert(File $file){
        $result = null;
        $pngFile = preg_replace('/(\.svg)$/', ".png", $file->getBasename());
        $pngFilename = $this->getPngDirPath() . DIRECTORY_SEPARATOR . $pngFile;
        $cmd = "inkscape -z --export-png=$pngFilename " . $file->getRealPath();
        shell_exec($cmd);
        if(file_exists($pngFilename)){
            $result = new File($pngFilename);
        }

        return $result;
    }

    public function getSvgDirPath(){
        $dir = $this->convertDir . DIRECTORY_SEPARATOR . 'svg';
        if(!is_dir($dir)){
            if(file_exists($dir)){
                unlink($dir);
            }
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    public function getPngDirPath(){
        $dir = $this->convertDir . DIRECTORY_SEPARATOR . 'png';
        if(!is_dir($dir)){
            if(file_exists($dir)){
                unlink($dir);
            }
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

}