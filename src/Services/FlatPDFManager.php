<?php


namespace App\Services;


use App\Entity\Building;
use App\Entity\BuildingPlacement;
use App\Entity\BuildingProgress;
use App\Entity\BuildingProgressItem;
use App\Entity\Contacts;
use App\Entity\Flat;
use App\Entity\Page;
use App\Entity\PageImage;
use App\Repository\BuildingProgressRepository;
use App\Repository\BuildingRepository;
use App\Repository\ContactsRepository;
use App\Repository\FlatRepository;
use App\Repository\FloorRepository;
use App\Repository\PageRepository;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class FlatPDFManager
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Pdf
     */
    private $pdf;

    /**
     * @var FlatRepository
     */
    private $flatRepository;

    /**
     * @var FloorRepository
     */
    private $floorRepository;

    /**
     * @var BuildingRepository
     */
    private $buildingRepository;

    /**
     * @var ContactsRepository
     */
    private $contactsRepository;

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var BuildingProgressRepository
     */
    private $buildingProgressRepository;

    /**
     * @var string
     */
    private $pdfDir;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $scheme;

    public function __construct(
        Environment $twig,
        Pdf $pdf,
        FlatRepository $flatRepository,
        FloorRepository $floorRepository,
        BuildingRepository $buildingRepository,
        ContactsRepository $contactsRepository,
        PageRepository $pageRepository,
        BuildingProgressRepository $buildingProgressRepository,
        string $pdfDir,
        string $host,
        string $scheme
    )
    {
        $this->twig = $twig;
        $this->pdf = $pdf;
        $this->flatRepository = $flatRepository;
        $this->floorRepository = $floorRepository;
        $this->buildingRepository = $buildingRepository;
        $this->contactsRepository = $contactsRepository;
        $this->pageRepository = $pageRepository;
        $this->buildingProgressRepository = $buildingProgressRepository;
        $this->pdfDir = $pdfDir;
        $this->host = $host;
        $this->scheme = $scheme;
    }

    public function renderFlat($flatNumber){
        $flat = $this->flatRepository->findOneBy(['number' => $flatNumber]);
        if(is_null($flat)){
            throw new Exception("Flat not found");
        }
        $floors = $this->getMaxFloors();
        $building = $this->getBuilding();
        $contacts = $this->getContacts();
        list($placementsLeft, $placementsRight) = $this->getPlacements($building);
        list($advantagesLeft, $advantagesRight) = $this->getAdvantages();
        $progress = $this->getBuildingProgress();
        list($progressLeft, $progressRight) = $this->getProgressPhoto($progress);
        $html = $this->getHtml(
            $flat,
            $floors,
            $building,
            $contacts,
            $placementsLeft,
            $placementsRight,
            $advantagesLeft,
            $advantagesRight,
            $progress,
            $progressLeft,
            $progressRight
        );
        if(isset($_GET['dump'])){
            echo $html; die;
        }
        $filename = $this->getFilename($flat->getNumber());
        $this->writeFile($filename, $html);
        $this->pdf->reset();
    }

    public function renderFloor($floorNumber){
        $floor = $this->floorRepository->findOneBy(['number' => $floorNumber]);
        if(is_null($floor)){
            throw new Exception;
        }
        $floors = $this->getMaxFloors();
        $building = $this->getBuilding();
        $contacts = $this->getContacts();
        list($placementsLeft, $placementsRight) = $this->getPlacements($building);
        list($advantagesLeft, $advantagesRight) = $this->getAdvantages();
        $progress = $this->getBuildingProgress();
        list($progressLeft, $progressRight) = $this->getProgressPhoto($progress);
        foreach ($floor->getFlats() as $flat){
            $html = $this->getHtml(
                $flat,
                $floors,
                $building,
                $contacts,
                $placementsLeft,
                $placementsRight,
                $advantagesLeft,
                $advantagesRight,
                $progress,
                $progressLeft,
                $progressRight
            );
            $filename = $this->getFilename($flat->getNumber());
            $this->writeFile($filename, $html);
            $this->pdf->reset();
        }
    }

    public function renderAll(){
        $flats = $this->flatRepository->findAll();
        $floors = $this->getMaxFloors();
        $building = $this->getBuilding();
        $contacts = $this->getContacts();
        list($placementsLeft, $placementsRight) = $this->getPlacements($building);
        list($advantagesLeft, $advantagesRight) = $this->getAdvantages();
        $progress = $this->getBuildingProgress();
        list($progressLeft, $progressRight) = $this->getProgressPhoto($progress);
        foreach ($flats as $flat){
            $html = $this->getHtml(
                $flat,
                $floors,
                $building,
                $contacts,
                $placementsLeft,
                $placementsRight,
                $advantagesLeft,
                $advantagesRight,
                $progress,
                $progressLeft,
                $progressRight
            );
            $filename = $this->getFilename($flat->getNumber());
            $this->writeFile($filename, $html);
            $this->pdf->reset();
        }
    }

    /**
     * @param $flatNumber
     * @param Request|null $request
     * @return string
     */
    public function getFileURL($flatNumber, $request = null){
        $result = null;
        if(file_exists($this->getFilename($flatNumber))){
            $result = "/pdf/$flatNumber.pdf";
            if(!is_null($request)){
                $result = $request->getSchemeAndHttpHost() . $result;
            }
        }

        return $result;
    }

    public function getFilename($flatNumber){
        return $this->pdfDir . DIRECTORY_SEPARATOR . $flatNumber . '.pdf';
    }

    protected function writeFile($filename, $html){
        $this->pdf->fileOutput($filename, $html);
    }

    protected function getHtml(
        $flat,
        $floors,
        $building,
        $contacts,
        $placementsLeft,
        $placementsRight,
        $advantagesLeft,
        $advantagesRight,
        $progress,
        $progressLeft,
        $progressRight
    ){
        $html = $this->twig->render('pdf/flat.html.twig', [
            'flat' => $flat,
            'floors' => $floors,
            'building' => $building,
            'contacts' => $contacts,
            'placementsLeft' => $placementsLeft,
            'placementsRight' => $placementsRight,
            'advantagesLeft' => $advantagesLeft,
            'advantagesRight' => $advantagesRight,
            'progress' => $progress,
            'progressLeft' => $progressLeft,
            'progressRight' => $progressRight,
            'httpHost' => $this->scheme . "://" . $this->host
        ]);

        return $html;
    }

    /**
     * @return int|mixed|string
     */
    protected function getMaxFloors(){
        return (int)$this->floorRepository->getMaxFloor();
    }

    /**
     * @return Building
     */
    protected function getBuilding(){
        $building = $this->buildingRepository->findOneBy([]);
        if(is_null($building)){
            $building = new Building();
        }

        return $building;
    }

    /**
     * @return Contacts
     */
    protected function getContacts(){
        $contacts = $this->contactsRepository->findOneBy([]);
        if(is_null($contacts)){
            $contacts = new Contacts();
        }

        return $contacts;
    }

    /**
     * @param Building $building
     * @return BuildingPlacement[][]
     */
    protected function getPlacements($building){
        /** @var BuildingPlacement[] $placementsLeft */
        $placementsLeft = [];
        /** @var BuildingPlacement[] $placementsRight */
        $placementsRight = [];
        foreach ($building->getPlacements() as $placement){
            if(count($placementsLeft) == count($placementsRight)){
                $placementsLeft[] = $placement;
            }
            else{
                $placementsRight[] = $placement;
            }
        }

        return [$placementsLeft, $placementsRight];
    }

    /**
     * @return PageImage[][]
     */
    protected function getAdvantages(){
        /** @var PageImage[] $advantagesLeft */
        $advantagesLeft = [];
        /** @var PageImage[] $advantagesRight */
        $advantagesRight = [];
        $page = $this->pageRepository->findOneBy(['type' => Page::TYPE_INDEX]);
        if(!is_null($page)){
            $i = 0;
            foreach ($page->getImages() as $image){
                $i++;
                $image->index = $i;
                if(count($advantagesLeft) <= 2){
                    $advantagesLeft[] = $image;
                }
                else{
                    $advantagesRight[] = $image;
                }
                if($i == 6){
                    break;
                }
            }
        }

        return [$advantagesLeft, $advantagesRight];
    }

    /**
     * @return BuildingProgress|null
     */
    protected function getBuildingProgress(){
        return $this->buildingProgressRepository->findOneBy([], ['date' => 'DESC']);
    }

    /**
     * @param BuildingProgress $buildingProgress
     * @return BuildingProgressItem[][]
     */
    protected function getProgressPhoto($buildingProgress){
        /** @var BuildingProgressItem[] $progressLeft */
        $progressLeft = [];
        /** @var BuildingProgressItem[] $progressRight */
        $progressRight = [];
        if(!is_null($buildingProgress)){
            $i = 0;
            foreach ($buildingProgress->getItems() as $item){
                $i++;
                if(count($progressLeft) == count($progressRight)){
                    $progressLeft[] = $item;
                }
                else{
                    $progressRight[] = $item;
                }
                if($i == 6){
                    break;
                }
            }
        }

        return [$progressLeft, $progressRight];
    }
}