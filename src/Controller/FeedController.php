<?php

namespace App\Controller;

use App\Entity\Flat;
use App\Entity\YandexYmlShop;
use App\Feed\Generator\GlavBazaGenerator;
use App\Feed\Generator\YaRealtyGenerator;
use App\Repository\BuildingRepository;
use App\Repository\ContactsRepository;
use App\Repository\FlatRepository;
use App\Repository\FloorRepository;
use App\Services\SVG2PNGConverter;
use App\Services\YandexYmlComposer;
use Eyetronic\YandexBuildingYml\YmlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FeedController
 * @package App\Controller
 *
 * @Route("/feed", name="feed_")
 */
class FeedController extends AbstractController
{

    /**
     * @Route("/glavbaza.xml", name="glavbaza")
     * @param GlavBazaGenerator $generator
     * @param FlatRepository $flatRepository
     * @param ContactsRepository $contactsRepository
     * @param BuildingRepository $buildingRepository
     * @param FloorRepository $floorRepository
     * @return Response
     */
    public function glavBaza(
        GlavBazaGenerator $generator,
        FlatRepository $flatRepository,
        ContactsRepository $contactsRepository,
        BuildingRepository $buildingRepository,
        FloorRepository $floorRepository
    ){
        $flats = $flatRepository->findBy(['status' => [Flat::STATUS_FREE, Flat::STATUS_RESERVED]]);
        $contacts = $contactsRepository->findOneBy([]);
        $building = $buildingRepository->findOneBy([]);
        $totalFloors = $floorRepository->getMaxFloor();
        $data = $generator->generate($flats, $contacts, $building, $totalFloors);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'text/xml; charset=utf-8');

        return $response;
    }

    /**
     * @Route("/pn.xml", name="pn")
     * @param GlavBazaGenerator $generator
     * @param FlatRepository $flatRepository
     * @param ContactsRepository $contactsRepository
     * @param BuildingRepository $buildingRepository
     * @param FloorRepository $floorRepository
     * @return Response
     */
    public function pn(
        GlavBazaGenerator $generator,
        FlatRepository $flatRepository,
        ContactsRepository $contactsRepository,
        BuildingRepository $buildingRepository,
        FloorRepository $floorRepository
    ){
        $flats = $flatRepository->findBy(['status' => [Flat::STATUS_FREE]]);
        $contacts = $contactsRepository->findOneBy([]);
        $building = $buildingRepository->findOneBy([]);
        $totalFloors = $floorRepository->getMaxFloor();
        $data = $generator->generate($flats, $contacts, $building, $totalFloors);

        $response = new Response($data);
        $response->headers->set('Content-Type', 'text/xml; charset=utf-8');

        return $response;
    }

    /**
     * @Route("/yandex.yml", name="yandex")
     * @return Response
     */
    public function yandex(YandexYmlComposer $composer){
        $shop = $this->getDoctrine()->getManager()->find(YandexYmlShop::class, 1);
        $xml = $composer->xml($shop);
        $response = new Response($xml);
        $response->headers->set('Content-Type', 'text/xml; charset=utf-8');

        return $response;
    }
}