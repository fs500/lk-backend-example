<?php


namespace App\Controller\API;


use App\Entity\Bank;
use App\Entity\Builder;
use App\Entity\Building;
use App\Entity\BuildingProgress;
use App\Entity\Calculator;
use App\Entity\Contacts;
use App\Entity\Document;
use App\Entity\Flat;
use App\Entity\Infrastructure;
use App\Entity\News;
use App\Entity\Offer;
use App\Entity\Page;
use App\Entity\PageInfrastructure;
use App\Entity\SocialNetwork;
use App\Repository\BankRepository;
use App\Repository\BuilderRepository;
use App\Repository\BuildingProgressRepository;
use App\Repository\BuildingRepository;
use App\Repository\CalculatorRepository;
use App\Repository\ContactsRepository;
use App\Repository\DocumentRepository;
use App\Repository\FlatRepository;
use App\Repository\FloorRepository;
use App\Repository\InfrastructureRepository;
use App\Repository\NewsRepository;
use App\Repository\OfferRepository;
use App\Repository\PageInfrastructureRepository;
use App\Repository\PageRepository;
use App\Repository\SocialNetworkRepository;
use App\Services\FileUrlHelper;
use App\Services\LinkHelper;
use App\Services\SettingRegistry;
use App\View\ContactsItemView;
use App\View\DocumentItemView;
use App\View\HowToGetItemView;
use App\View\LiveBroadcastView;
use App\View\MapView;
use App\View\MortgageCalculatorView;
use App\View\NewsListItemView;
use App\View\PageBuildingProgressMonthView;
use App\View\PageBuildingProgressView;
use App\View\PageBuildingProgressYearView;
use App\View\PageCommerceView;
use App\View\PageContactsView;
use App\View\PageDocumentsView;
use App\View\PageHowToBuyView;
use App\View\PageIndexBuilderView;
use App\View\PageIndexFlatItemView;
use App\View\PageIndexFlatView;
use App\View\PageIndexInfrastructureGroupItemView;
use App\View\PageIndexInfrastructureView;
use App\View\PageIndexReasonItemView;
use App\View\PageIndexSlideItemView;
use App\View\PageIndexView;
use App\View\PageLocationView;
use App\View\SocialNetworkView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class PageController
 * @package App\Controller\API
 * @Route("/api/page", name="api_page_")
 */
class PageController extends AbstractController
{
    /**
     * @var FileUrlHelper
     */
    protected $fileUrlHelper;

    /**
     * @var LinkHelper
     */
    protected $linkHelper;

    /**
     * @var SettingRegistry
     */
    protected $settingRegistry;

    public function __construct(FileUrlHelper $fileUrlHelper, LinkHelper $linkHelper, SettingRegistry $settingRegistry)
    {
        $this->fileUrlHelper = $fileUrlHelper;
        $this->linkHelper = $linkHelper;
        $this->settingRegistry = $settingRegistry;
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/index",
     *     summary="Главная страница",
     *     @OA\Response(
     *       response=200,
     *       description="Данные главной страницы сайта",
     *       @OA\JsonContent(ref="#/components/schemas/PageIndex")
     *     )
     * )
     *
     * @Route("/index", "index")
     * @param PageRepository $repository
     * @param BuilderRepository $builderRepository
     * @param PageInfrastructureRepository $pageInfrastructureRepository
     * @param InfrastructureRepository $infrastructureRepository
     * @param FlatRepository $flatRepository
     * @param FloorRepository $floorRepository
     * @param NewsRepository $newsRepository
     * @param ContactsRepository $contactsRepository
     * @return JsonResponse
     */
    public function index(PageRepository $repository,
                          BuilderRepository $builderRepository,
                          PageInfrastructureRepository $pageInfrastructureRepository,
                          InfrastructureRepository $infrastructureRepository,
                          FlatRepository $flatRepository,
                          FloorRepository $floorRepository,
                          NewsRepository $newsRepository,
                          ContactsRepository $contactsRepository
    ){
        $page = $repository->findOneBy(['type' => Page::TYPE_INDEX]);
        if(is_null($page)){
            throw new BadRequestHttpException();
        }
        $builder = $builderRepository->findOneBy([]);
        $pageInfrastructure = $pageInfrastructureRepository->findOneBy([]);
        $infrastructureGroups = $infrastructureRepository->findBy([], ['sort' => 'ASC']);
        $flats = $flatRepository->getFlatsForWidget();
        $floors = $floorRepository->getMaxFloor();
        $news = $newsRepository->findNewest();
        $contacts = $contactsRepository->findOneBy([]);
        $view = $this->populateIndexView(
            $page,
            $builder,
            $pageInfrastructure,
            $infrastructureGroups,
            $flats,
            $floors,
            $news,
            $contacts
        );

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/contacts",
     *     summary="Контакты",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы контактов",
     *       @OA\JsonContent(ref="#/components/schemas/PageContacts")
     *     )
     * )
     *
     * @Route("/contacts", "contacts")
     * @param ContactsRepository $contactsRepository
     * @return JsonResponse
     */
    public function contacts(ContactsRepository $contactsRepository, SocialNetworkRepository $socialNetworkRepository){
        $contacts = $contactsRepository->findOneBy([]);
        if(is_null($contacts)){
            throw new BadRequestHttpException();
        }
        $socialNetworks = $socialNetworkRepository->findAll();
        $view = $this->populateContactsView($contacts, $socialNetworks);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/how_to_buy",
     *     summary="Как купить",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы 'Как Купить'",
     *       @OA\JsonContent(ref="#/components/schemas/PageHowToBuy")
     *     )
     * )
     *
     * @Route("/how_to_buy", "how_to_buy")
     * @param PageRepository $pageRepository
     * @param OfferRepository $offerRepository
     * @param CalculatorRepository $calculatorRepository
     * @param BankRepository $bankRepository
     * @param FlatRepository $flatRepository
     * @return JsonResponse
     */
    public function howToBuy(
        PageRepository $pageRepository,
        OfferRepository $offerRepository,
        CalculatorRepository $calculatorRepository,
        BankRepository $bankRepository,
        FlatRepository $flatRepository
    ){
        $page = $pageRepository->findOneBy(['type' => Page::TYPE_HOW_TO_BUY]);
        if(is_null($page)){
            throw new BadRequestHttpException();
        }
        $offers = $offerRepository->findBy([], ['deadline' => 'asc']);
        $calculator = $calculatorRepository->findOneBy([]);
        $banks = $bankRepository->findBy([], ['sort' => 'ASC']);
        $prices = $flatRepository->getMinMaxPrice();

        $view = $this->populateHowToBuyView($page, $offers, $calculator, $banks, $prices);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/documents",
     *     summary="Документы",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы 'Документы'",
     *       @OA\JsonContent(ref="#/components/schemas/PageDocuments")
     *     )
     * )
     *
     * @Route("/documents", "documents")
     * @param DocumentRepository $documentRepository
     * @return JsonResponse
     */
    public function documents(DocumentRepository $documentRepository){
        $documents = $documentRepository->findBy([], ['date' => 'DESC']);

        $view = $this->populateDocumentsView($documents);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/building_progress",
     *     summary="Ход строительства",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы 'Ход строительства'",
     *       @OA\JsonContent(ref="#/components/schemas/PageBuildingProgress")
     *     )
     * )
     *
     * @Route("/building_progress", "building_progress")
     * @param BuildingProgressRepository $buildingProgressRepository
     * @param BuildingRepository $buildingRepository
     * @return JsonResponse
     */
    public function buildingProgress(
        BuildingProgressRepository $buildingProgressRepository,
        BuildingRepository $buildingRepository
    ){
        $items = $buildingProgressRepository->findBy([],['date' => 'DESC']);
        $building = $buildingRepository->findOneBy([]);
        $view = $this->populateBuildingProgressView($items, $building);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/commerce",
     *     summary="Коммерция",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы 'Коммерция'",
     *       @OA\JsonContent(ref="#/components/schemas/PageCommerce")
     *     )
     * )
     *
     * @Route("/commerce", "commerce")
     * @param PageRepository $pageRepository
     * @return JsonResponse
     */
    public function commerce(PageRepository $pageRepository){
        $page = $pageRepository->findOneBy(['type' => PAge::TYPE_COMMERCE]);
        if(is_null($page)){
            throw new BadRequestHttpException();
        }
        $view = $this->populateCommerceView($page);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Страницы"},
     *     path="/api/page/location",
     *     summary="Страница Расположение",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы Расположение",
     *       @OA\JsonContent(ref="#/components/schemas/PageLocation")
     *     )
     * )
     * @Route("/location", "location")
     * @param PageRepository $pageRepository
     * @param PageInfrastructureRepository $pageInfrastructureRepository
     * @param ContactsRepository $contactsRepository
     * @param InfrastructureRepository $infrastructureRepository
     * @return JsonResponse
     */
    public function location(
        PageRepository $pageRepository,
        PageInfrastructureRepository $pageInfrastructureRepository,
        ContactsRepository $contactsRepository,
        InfrastructureRepository $infrastructureRepository
    ){
        $page = $pageRepository->findOneBy(['type' => PAge::TYPE_LOCATION]);
        $pageInfrastructure = $pageInfrastructureRepository->findOneBy([]);
        $contacts = $contactsRepository->findOneBy([]);
        $infrastructureGroups = $infrastructureRepository->findBy([], ['sort' => 'ASC']);
        if(is_null($page)){
            throw new BadRequestHttpException();
        }
        $view = $this->populateLocationView(
            $page,
            $pageInfrastructure,
            $contacts,
            $infrastructureGroups
        );

        return new JsonResponse($view);
    }

    /**
     * @param Page $page
     * @param Builder|null $builder
     * @param PageInfrastructure $pageInfrastructure
     * @param Infrastructure[] $infrastructureGroups
     * @param Flat[] $flats
     * @param News[] $news
     * @param $floors
     * @param Contacts $contacts
     * @return PageIndexView
     */
    protected function populateIndexView(
        Page $page,
        $builder,
        $pageInfrastructure,
        $infrastructureGroups,
        $flats,
        $floors,
        $news,
        $contacts
    ){
        $view = new PageIndexView();
        foreach ($page->getSlides() as $slide){
            $sView = new PageIndexSlideItemView();
            $view->slides[] = $sView;
            $sView->image = $this->fileUrlHelper->get($slide, 'imageFile', $slide->getImage());
            $sView->header = $slide->getHeader();
            $sView->description = $slide->getDescription();
            $sView->link = $this->linkHelper->get($slide->getLink());
            $sView->liveBroadcast = $this->linkHelper->get($slide->getLiveBroadcast());
        }
        $view->header = $page->getHeader();
        $view->text = $page->getText();
        $view->leftImage = $this->fileUrlHelper->get($page, 'imageFile1', $page->getImage1());
        $view->rightImage = $this->fileUrlHelper->get($page, 'imageFile2', $page->getImage2());
        $view->reasonHeaderTop = $page->getSubHeader1();
        $view->reasonHeaderBottom = $page->getSubHeader2();
        foreach ($page->getImages() as $image){
            $rView = new PageIndexReasonItemView();
            $view->reasons[] = $rView;
            $rView->header = $image->getHeader();
            $rView->text = $image->getText();
            $rView->image = $this->fileUrlHelper->get($image, 'imageFile', $image->getImage());
        }

        if(!is_null($builder)){
            $bView = new PageIndexBuilderView();
            $view->builder = $bView;
            $bView->logo = $this->fileUrlHelper->get($builder,'logoFile',$builder->getLogo());
            $bView->header = $builder->getHeader();
            $bView->text = $builder->getText();
            foreach ($builder->getAdvantages() as $advantage){
                $bView->achievements[] = [
                    'header' => $advantage->getHeader(),
                    'subHeader' => $advantage->getSubHeader()
                ];
            }
        }

        $iView = new PageIndexInfrastructureView();
        $view->infrastructure = $iView;
        if(!is_null($pageInfrastructure)){
            $iView->headerTop = $pageInfrastructure->getHeader1();
            $iView->headerBottom = $pageInfrastructure->getHeader2();
            $iView->map = new MapView();
            $iView->map->longitude = $pageInfrastructure->getLongitude();
            $iView->map->latitude = $pageInfrastructure->getLatitude();
            $iView->map->scale = $pageInfrastructure->getScale();
        }
        if(!is_null($contacts)){
            $iView->buildingLatitude = $contacts->getObjectLatitude();
            $iView->buildingLongitude = $contacts->getObjectLongitude();
            $iView->buildingIcon = $this->fileUrlHelper->get($contacts, 'objectImageFile', $contacts->getObjectImage());
        }
        foreach ($infrastructureGroups as $iGroup){
            $iGroupView = new PageIndexInfrastructureGroupItemView();
            $iView->groups[] = $iGroupView;
            $iGroupView->id = $iGroup->getId();
            $iGroupView->header = $iGroup->getHeader();
            $iGroupView->icon = $this->fileUrlHelper->get($iGroup, 'iconFile', $iGroup->getIcon());
            foreach ($iGroup->getItems() as $item){
                $iGroupView->items[] = [
                    'header' => $item->getName(),
                    'description' => $item->getDescription(),
                    'address' => $item->getAddress(),
                    'latitude' => $item->getLatitude(),
                    'longitude' => $item->getLongitude(),
                ];
            }
        }
        $flatView = new PageIndexFlatView();
        $view->flat = $flatView;
        $flatView->header = $page->getSubHeader3();
        $flatView->link = $this->linkHelper->get($page->getLink());
        foreach ($flats as $flat){
            $flatItemView = new PageIndexFlatItemView();
            $flatView->items[] = $flatItemView;
            $flatItemView->plan = $this->fileUrlHelper->get($flat,'planFile',$flat->getPlan());
            $flatItemView->price = $flat->getPrice();
            $flatItemView->priceAction = $flat->getPriceAction();
            $flatItemView->priceActionText = $this->settingRegistry->get('common/priceActionText');
            $flatItemView->floor = $flat->getFloor() ? $flat->getFloor()->getNumber() : null;
            $flatItemView->totalFloors = (int)$floors;
            $flatItemView->rooms = $flat->getRooms();
            $flatItemView->area = $flat->getArea();
            $flatItemView->number = $flat->getNumber();
        }

        $view->news = [];
        foreach ($news as $n){
            $itemView = new NewsListItemView();
            $view->news[] = $itemView;
            $itemView->id = $n->getId();
            $itemView->path = $n->getPath();
            $itemView->date = $n->getDate() ? $n->getDate()->format('Y-m-d') : null;
            $itemView->description = $n->getDescription();
            $itemView->header = $n->getHeader();
        }

        return $view;
    }

    /**
     * @param Contacts $contacts
     * @param SocialNetwork[] $socialNetworks
     * @return PageContactsView
     */
    protected function populateContactsView(Contacts $contacts, $socialNetworks){
        $view = new PageContactsView();
        $view->header = $contacts->getHeader();
        $view->subHeader = $contacts->getSubHeader();

        $view->office = new ContactsItemView();
        $view->office->address = $contacts->getOfficeAddress();
        $view->office->mapIcon = $this->fileUrlHelper->get($contacts, 'officeImageFile', $contacts->getOfficeImage());
        $view->office->mapLatitude = $contacts->getOfficeLatitude();
        $view->office->mapLongitude = $contacts->getOfficeLongitude();
        $view->office->route = $this->linkHelper->get($contacts->getOfficeRoute());

        $view->object = new ContactsItemView();
        $view->object->address = $contacts->getObjectAddress();
        $view->object->mapIcon = $this->fileUrlHelper->get($contacts, 'objectImageFile', $contacts->getObjectImage());
        $view->object->mapLatitude = $contacts->getObjectLatitude();
        $view->object->mapLongitude = $contacts->getObjectLongitude();
        $view->object->route = $this->linkHelper->get($contacts->getObjectRoute());

        $view->map = new MapView();
        $view->map->latitude = $contacts->getMapLatitude();
        $view->map->longitude = $contacts->getMapLongitude();
        $view->map->scale = $contacts->getMapScale();

        $view->phone = $contacts->getPhone();
        $view->email = $contacts->getEmail();
        $view->socialNetworks = [];
        foreach ($socialNetworks as $sn){
            $snView = new SocialNetworkView();
            $view->socialNetworks[] = $snView;
            $snView->icon = $this->fileUrlHelper->get($sn, 'iconFile', $sn->getIcon());
            $snView->url = $sn->getUrl();
        }

        return $view;
    }

    /**
     * @param Page $page
     * @param Offer[] $offers
     * @param Calculator|null $calculator
     * @param Bank[] $banks
     * @param array $prices
     * @return PageHowToBuyView
     */
    protected function populateHowToBuyView(Page $page, $offers, $calculator, $banks, $prices){
        $view = new PageHowToBuyView();
        $view->headerTopLine = $page->getHeader();
        $view->headerBottomLine = $page->getSubHeader1();
        $view->image = $this->fileUrlHelper->get($page, 'imageFile1', $page->getImage1());
        $view->terms = [];
        foreach ($page->getTerms() as $term){
            $view->terms[] = [
                'header' => $term->getHeader(),
                'description' => $term->getText(),
                'icon' => $this->fileUrlHelper->get($term, 'iconFile', $term->getIcon())
            ];
        }

        $view->howToHeader = $page->getSubHeader2();
        $view->howToSubheader = $page->getSubHeader3();
        $view->howToTerms = [];
        foreach ($page->getHowTos() as $ht){
            $view->howToTerms[] = [
                'description' => $ht->getText(),
                'icon' => $this->fileUrlHelper->get($ht, 'iconFile', $ht->getIcon())
            ];
        }

        $view->promos = [];
        foreach ($offers as $offer){
            $view->promos[] = [
                'header' => $offer->getHeader(),
                'description' => $offer->getDescription(),
                'deadline' => $offer->getDeadline()->format('Y-m-d'),
                'text' => $offer->getText()
            ];
        }

        $view->reservationImage = $this->fileUrlHelper->get($page, 'imageFile2', $page->getImage2());
        $view->reservationHeader = $page->getSubHeader4();
        $view->reservationTerms = [];
        foreach ($page->getHowToReservations() as $reservation){
            $view->reservationTerms[] = [
                'header' => $reservation->getHeader(),
                'description' => $reservation->getText(),
                'icon' => $this->fileUrlHelper->get($reservation, 'iconFile', $reservation->getIcon())
            ];
        }

        $view->calculator = new MortgageCalculatorView();
        $view->calculator->priceMin = $prices['min'];
        $view->calculator->priceMax = $prices['max'];
        if($calculator){
            $view->calculator->defaultPrice = $calculator->getPriceDefault();

            $view->calculator->paymentMin = $calculator->getPriceDefault()/100*$calculator->getPaymentMin();
            $view->calculator->paymentMax = $calculator->getPriceDefault()/100*$calculator->getPaymentMax();
            $view->calculator->defaultPayment = $calculator->getPriceDefault()/100*$calculator->getDefaultPayment();

            $view->calculator->yearsMin = $calculator->getYearsMin();
            $view->calculator->yearsMax = $calculator->getYearsMax();
            $view->calculator->defaultYear = $calculator->getDefaultYears();

            $view->calculator->rateMin = $calculator->getRateMin();
            $view->calculator->rateMax = $calculator->getRateMax();
            $view->calculator->defaultRate = $calculator->getRateDefault();
        }

        $view->bankHeader = $page->getSubHeader5();
        $view->banks = [];
        foreach ($banks as $bank){
            $view->banks[] = [
                'header' => $bank->getHeader(),
                'image' => $this->fileUrlHelper->get($bank, 'logoFile', $bank->getLogo())
            ];
        }

        return $view;
    }

    /**
     * @param BuildingProgress[] $items
     * @param Building $building
     * @return PageBuildingProgressView
     */
    protected function populateBuildingProgressView($items, $building){
        $view = new PageBuildingProgressView();
        if($building && $building->getLiveBroadcastURL()){
            $view->liveBroadcast = new LiveBroadcastView();
            $view->liveBroadcast->type = "iframe";
            $view->liveBroadcast->url = $building->getLiveBroadcastURL();
        }
        $view->years = [];
        $currentYear = null;
        $yearView = new PageBuildingProgressYearView();
        foreach ($items as $item){
            if($item->getDate()->format('Y') != $currentYear){
                $currentYear = $item->getDate()->format('Y');
                $yearView = new PageBuildingProgressYearView();
                $yearView->year = (int)$currentYear;
                $view->years[] = $yearView;
            }
            $month = new PageBuildingProgressMonthView();
            $yearView->months[] = $month;
            $month->month = (int)$item->getDate()->format('n');
            $month->description = $item->getDescription();
            $month->images = [];
            foreach ($item->getItems() as $i){
                $month->images[] = $this->fileUrlHelper->get($i, 'photoFile', $i->getPhoto());
            }
        }

        return $view;
    }

    /**
     * @param Document[] $documents
     * @return PageDocumentsView
     */
    protected function populateDocumentsView($documents){
        $view = new PageDocumentsView();

        foreach ($documents as $document){
            $dView = new DocumentItemView();
            $view->documents[] = $dView;
            $dView->date = $document->getDate()->format('Y-m-d');
            $dView->header = $document->getHeader();
            $dView->type = $document->getType();
            $dView->name = $document->getName();
            $dView->url = $this->fileUrlHelper->get($document,'uploadedFile', $document->getFile());
            $dView->size = $document->getSize();
        }

        return $view;
    }

    /**
     * @param Page $page
     * @return PageCommerceView
     */
    protected function populateCommerceView(Page $page){
        $view = new PageCommerceView();
        $view->header = $page->getHeader();
        $view->leftHeader = $page->getSubHeader1();
        $view->leftImage = $this->fileUrlHelper->get($page, 'imageFile1', $page->getImage1());
        $view->rightHeader = $page->getSubHeader2();
        $view->rightImage = $this->fileUrlHelper->get($page, 'imageFile2', $page->getImage2());
        $view->promoHeader = $page->getSubHeader3();
        $view->promoText = $page->getText();
        $view->promoItems = [];
        $view->promoItems[] = [
            'header' => 'Площадь помещений',
            'description' => null
        ];
        $view->promoItems[] = [
            'header' => 'Стоимость помещений',
            'description' => null
        ];
        $view->properties = [];
        foreach ($page->getImages() as $image){
            $view->properties[] = [
                'header' => $image->getHeader(),
                'description' => $image->getText(),
                'image' => $this->fileUrlHelper->get($image, 'imageFile', $image->getImage())
            ];
        }

        $view->rooms = [];

        return $view;
    }

    /**
     * @param Page $page
     * @param PageInfrastructure|null $pageInfrastructure
     * @param Contacts|null $contacts
     * @param Infrastructure[] $infrastructureGroups
     * @return PageLocationView
     */
    protected function populateLocationView(
        Page $page,
        ?PageInfrastructure $pageInfrastructure,
        ?Contacts $contacts,
        $infrastructureGroups
    ){
        $view = new PageLocationView();
        $view->header = $page->getHeader();
        $view->howToGet = [];
        foreach ($page->getHowTos() as $ht){
            $hView = new HowToGetItemView();
            $hView->header = $ht->getHeader();
            $hView->icon = $this->fileUrlHelper->get($ht, 'iconFile', $ht->getIcon());
            $hView->text = $ht->getText();
            $hView->note = $ht->getText2();
        }
        $view->infrastructure = new PageIndexInfrastructureView();
        $view->infrastructure->headerTop = $page->getSubHeader1();
        $view->infrastructure->headerBottom = $page->getSubHeader2();
        if(!is_null($pageInfrastructure)){
            $view->infrastructure->map = new MapView();
            $view->infrastructure->map->longitude = $pageInfrastructure->getLongitude();
            $view->infrastructure->map->latitude = $pageInfrastructure->getLatitude();
            $view->infrastructure->map->scale = $pageInfrastructure->getScale();
        }
        if(!is_null($contacts)){
            $view->infrastructure->buildingLatitude = $contacts->getObjectLatitude();
            $view->infrastructure->buildingLongitude = $contacts->getObjectLongitude();
            $view->infrastructure->buildingIcon = $this->fileUrlHelper->get($contacts, 'objectImageFile', $contacts->getObjectImage());
        }
        $view->howToGet = [];
        foreach ($page->getHowTos() as $ht){
            $hView = new HowToGetItemView();
            $view->howToGet[] = $hView;
            $hView->header = $ht->getHeader();
            $hView->text = $ht->getText();
            $hView->note = $ht->getText2();
            $hView->icon = $this->fileUrlHelper->get($ht, 'iconFile', $ht->getIcon());
        }
        foreach ($infrastructureGroups as $iGroup){
            $iGroupView = new PageIndexInfrastructureGroupItemView();
            $view->infrastructure->groups[] = $iGroupView;
            $iGroupView->id = $iGroup->getId();
            $iGroupView->header = $iGroup->getHeader();
            $iGroupView->icon = $this->fileUrlHelper->get($iGroup, 'iconFile', $iGroup->getIcon());
            foreach ($iGroup->getItems() as $item){
                $iGroupView->items[] = [
                    'header' => $item->getName(),
                    'description' => $item->getDescription(),
                    'address' => $item->getAddress(),
                    'latitude' => $item->getLatitude(),
                    'longitude' => $item->getLongitude(),
                ];
            }
        }

        return $view;
    }
}