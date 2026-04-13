<?php


namespace App\Controller\API;


use App\Entity\Flat;
use App\Entity\Floor;
use App\Entity\Form\FlatParameter;
use App\Form\FlatParameterType;
use App\Repository\FlatRepository;
use App\Repository\FloorRepository;
use App\Services\FileUrlHelper;
use App\Services\FlatPDFManager;
use App\Services\SettingRegistry;
use App\View\FlatCardFloorView;
use App\View\FlatCardView;
use App\View\FlatFloorFlatView;
use App\View\FlatFloorView;
use App\View\FlatListItemView;
use App\View\FlatListView;
use App\View\FlatParametersView;
use App\View\FlatVisualFloorFlatView;
use App\View\FlatVisualFloorView;
use App\View\FlatVisualView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class FlatController
 * @package App\Controller\API
 *
 * @Route("/api/flat",name="api_flat_")
 */
class FlatController extends AbstractController
{
    /**
     * @var FileUrlHelper
     */
    public FileUrlHelper $fileUrlHelper;

    /**
     * @var FlatPDFManager
     */
    private $pdfManager;

    /**
     * @var Request|null
     */
    private $request;

    /**
     * @var SettingRegistry
     */
    private $settingRegistry;

    public function __construct(FileUrlHelper $fileUrlHelper, FlatPDFManager $manager, RequestStack $requestStack, SettingRegistry $settingRegistry)
    {
        $this->fileUrlHelper = $fileUrlHelper;
        $this->pdfManager = $manager;
        $this->request = $requestStack->getCurrentRequest();
        $this->settingRegistry = $settingRegistry;
    }

    /**
     * @OA\Get(
     *     tags={"Квартиры"},
     *     path="/api/flat/visual",
     *     summary="Визуальный выбор квартиры",
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы визуального выбора квартиры",
     *       @OA\JsonContent(ref="#/components/schemas/FlatVisual")
     *     )
     * )
     *
     * @Route("/visual", "visual")
     * @param FloorRepository $repository
     * @return JsonResponse
     */
    public function visual(FloorRepository $repository){
        $floors = $repository->findBy([], ['number' => 'ASC']);
        $view = $this->populateVisualView($floors);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Квартиры"},
     *     path="/api/flat/parameters",
     *     summary="Получение параметров для поиска квартиры",
     *     @OA\Response(
     *       response=200,
     *       description="Данные для формы подбора квартиры по параметрам",
     *       @OA\JsonContent(ref="#/components/schemas/FlatParameters")
     *     )
     * )
     *
     * @Route("/parameters", "parameters")
     * @param FlatRepository $repository
     * @return JsonResponse
     */
    public function parameters(FlatRepository $repository){
        $parameters = $repository->getParameters();
        $rooms = $repository->getInSaleRoomsType();
        $statuses = array_keys(FlatParameter::getStatusesChoices());
        $view = $this->populateParametersView($parameters, $rooms, $statuses);

        return new JsonResponse($view);
    }

    /**
     * @OA\Post(
     *     tags={"Квартиры"},
     *     path="/api/flat/list",
     *     summary="Список квартир по параметрам",
     *     @OA\Parameter(ref="#/components/parameters/rooms"),
     *     @OA\Parameter(ref="#/components/parameters/priceMin"),
     *     @OA\Parameter(ref="#/components/parameters/priceMax"),
     *     @OA\Parameter(ref="#/components/parameters/areaMin"),
     *     @OA\Parameter(ref="#/components/parameters/areaMax"),
     *     @OA\Parameter(ref="#/components/parameters/floorMin"),
     *     @OA\Parameter(ref="#/components/parameters/floorMax"),
     *     @OA\Parameter(ref="#/components/parameters/sortField"),
     *     @OA\Parameter(ref="#/components/parameters/sortOrder"),
     *     @OA\Parameter(ref="#/components/parameters/statuses"),
     *     @OA\Response(
     *       response=200,
     *       headers={
     *           @OA\Header(
     *               header="X-Total-Count",
     *               description="Количество квартир в списке",
     *               @OA\Schema(type="number", format="integer", example=15)
     *           )
     *       },
     *       description="Список квартир по параметрам",
     *       @OA\JsonContent(ref="#/components/schemas/FlatList")
     *     )
     * )
     *
     * @Route("/list", "list")
     * @param Request $request
     * @param FlatRepository $repository
     * @param FloorRepository $floorRepository
     * @return Response
     */
    public function list(
        Request $request,
        FlatRepository $repository,
        FloorRepository $floorRepository
    ){

        $entity = new FlatParameter();
        $entity->setSortField(FlatParameter::SORT_FIELD_PRICE);
        $entity->setSortOrder(FlatParameter::SORT_ORDER_ASC);
        $form = $this->createForm(FlatParameterType::class, $entity);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                /** @var Flat[] $flats */
                $flats = $repository->findAllBySearchForm($entity);
            }
            else{
                throw new BadRequestHttpException();
            }
        }
        else{
            /** @var Flat[] $flats */
            $flats = $repository->findAllBySearchForm($entity);
        }
        $floors = $floorRepository->getMaxFloor();
        $view = $this->populateListView($entity, $flats, $floors);
        $response = new JsonResponse($view);
        $response->headers->set('X-Total-Count', count($flats));

        /**
        return $this->render('form.html.twig', [
            'form' => $form->createView()
        ]);
        */

        return $response;
    }

    /**
     * @OA\Get(
     *     tags={"Квартиры"},
     *     path="/api/flat/floor/{floorNumber}",
     *     summary="Получение страницы этажа",
     *     @OA\Parameter(ref="#/components/parameters/floorNumber"),
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы этажа",
     *       @OA\JsonContent(ref="#/components/schemas/FlatFloor")
     *     )
     * )
     *
     * @Route("/floor/{floorNumber}", "floor")
     * @param FloorRepository $repository
     * @param $floorNumber
     * @return JsonResponse
     */
    public function floor(FloorRepository $repository, $floorNumber){
        $floor = $repository->findOneBy(['number' => $floorNumber]);

        if(is_null($floor)){
            throw new BadRequestHttpException();
        }
        $floors = $repository->findBy([], ['number' => 'ASC']);
        $view = $this->populateFloorView($floor, $floors);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Квартиры"},
     *     path="/api/flat/{floorNumber}/{flatNumber}",
     *     summary="Получение карточки квартиры",
     *     @OA\Parameter(ref="#/components/parameters/floorNumber"),
     *     @OA\Parameter(ref="#/components/parameters/flatNumber"),
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы карточки квартиры",
     *       @OA\JsonContent(ref="#/components/schemas/FlatCard")
     *     )
     * )
     *
     * @Route("/{floorNumber}/{flatNumber}", "card")
     * @param $floorNumber
     * @param $flatNumber
     * @param FlatRepository $repository
     * @param FloorRepository $floorRepository
     * @return JsonResponse
     */
    public function card($floorNumber, $flatNumber, FlatRepository $repository, FloorRepository $floorRepository){
        $flat = $repository->findOneBy(['number' => $flatNumber]);
        if(is_null($flat) || empty($flat->getFloor()) || $flat->getFloor()->getNumber() != $floorNumber){
            throw new BadRequestHttpException();
        }
        $floors = $floorRepository->findBy([],['number' => 'ASC']);
        $view = $this->populateCardView($flat, $floors);

        return new JsonResponse($view);
    }

    /**
     * @OA\Get(
     *     tags={"Квартиры"},
     *     path="/api/flat/{flatNumber}",
     *     summary="Получение карточки квартиры",
     *     @OA\Parameter(ref="#/components/parameters/flatNumber"),
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы карточки квартиры",
     *       @OA\JsonContent(ref="#/components/schemas/FlatCard")
     *     )
     * )
     *
     * @Route("/{flatNumber}", "single")
     * @param $flatNumber
     * @param FlatRepository $repository
     * @param FloorRepository $floorRepository
     * @return JsonResponse
     */
    public function single($flatNumber, FlatRepository $repository, FloorRepository $floorRepository){
        $flat = $repository->findOneBy(['number' => $flatNumber]);
        if(is_null($flat)){
            throw new BadRequestHttpException();
        }
        $floors = $floorRepository->findBy([],['number' => 'ASC']);
        $view = $this->populateCardView($flat, $floors);

        return new JsonResponse($view);
    }

    /**
     * @param Floor[] $floors
     * @return FlatVisualView
     */
    protected function populateVisualView($floors){
        $view = new FlatVisualView();
        $view->floors = $this->getFloorsSummary($floors);

        return $view;
    }

    protected function populateParametersView($parameters, $rooms, $statuses){
        $view = new FlatParametersView();

        foreach ($rooms as $r){
            $view->rooms[] = $r['rooms'];
        }

        $view->priceMin = $parameters['minPrice'];
        $view->priceMax = $parameters['maxPrice'];
        $view->areaMin = $parameters['minArea'];
        $view->areaMax = $parameters['maxArea'];
        $view->floorMin = $parameters['minFloor'];
        $view->floorMax = $parameters['maxFloor'];
        $view->statuses = $statuses;

        return $view;
    }

    /**
     * @param FlatParameter $form
     * @param Flat[] $flats
     * @param $floors
     * @return FlatListView
     */
    protected function populateListView(FlatParameter $form, $flats, $floors){
        $view = new FlatListView();
        $view->sortField = $form->getSortField();
        $view->sortOrder = $form->getSortOrder();
        $view->totalFloors = (int)$floors;
        foreach ($flats as $flat){
            $flatView = new FlatListItemView();
            $view->flats[] = $flatView;
            $flatView->id = $flat->getId();
            $flatView->number = $flat->getNumber();
            $flatView->rooms = $flat->getRooms();
            $flatView->status = $flat->getStatus();
            $flatView->area = $flat->getArea();
            $flatView->floor = $flat->getFloor() ? $flat->getFloor()->getNumber() : null;
            $flatView->price = $flat->getPrice();
            $flatView->priceFinish = $flat->getPriceFinish();
            $flatView->priceAction = $flat->getPriceAction();
            $flatView->priceActionText = $this->settingRegistry->get('common/priceActionText');
            $flatView->plan = $this->fileUrlHelper->get($flat, 'planFile', $flat->getPlan());
        }
        return $view;
    }

    /**
     * @param Floor $floor
     * @param Floor[] $floors
     * @return FlatFloorView
     */
    protected function populateFloorView(Floor $floor, $floors){
        $view = new FlatFloorView();
        $view->plan = $this->fileUrlHelper->get($floor, 'planFile', $floor->getPlan());
        $view->floors = $this->getFloorsSummary($floors);

        foreach ($floor->getFlats() as $flat){
            $flatView = new FlatFloorFlatView();
            $view->flats[] = $flatView;
            $flatView->id = $flat->getId();
            $flatView->number = $flat->getNumber();
            $flatView->rooms = $flat->getRooms();
            $flatView->area = $flat->getArea();
            $flatView->price = $flat->getPrice();
            $flatView->priceAction = $flat->getPriceAction();
            $flatView->priceActionText = $this->settingRegistry->get('common/priceActionText');
            $flatView->status = $flat->getStatus();
        }

        return $view;
    }

    /**
     * @param Flat $flat
     * @param Floor[] $floors
     * @return FlatCardView
     */
    protected function populateCardView(Flat $flat, $floors){
        $view = new FlatCardView();
        $totalFloors = 0;
        foreach ($floors as $floor){
            $floorView = new FlatCardFloorView();
            $view->floors[] = $floorView;
            $floorView->number = $floor->getNumber();
            $floorView->plan = $this->fileUrlHelper->get($floor, 'miniPlanFile', $floor->getMiniPlan());
            $totalFloors = $totalFloors < $floor->getNumber() ? $floor->getNumber() : $totalFloors;
            foreach ($floor->getFlats() as $f){
                $floorView->flats[] = [
                    'number' => $f->getNumber(),
                    'status' => $f->getStatus()
                ];
            }
        }
        $view->id = $flat->getId();
        $view->number = $flat->getNumber();
        $view->floor = $flat->getFloor() ? $flat->getFloor()->getNumber() : null;
        $view->totalFloors = $totalFloors;
        $view->rooms = $flat->getRooms();
        $view->area = $flat->getArea();
        $view->areaKitchen = $flat->getKitchenArea();
        $view->areaRooms = $flat->getRoomsArea();
        $view->price = $flat->getPrice();
        $view->priceFinish = $flat->getPriceFinish();
        $view->priceAction = $flat->getPriceAction();
        $view->priceActionText = $this->settingRegistry->get('common/priceActionText');
        $view->status = $flat->getStatus();
        $view->plan = $this->fileUrlHelper->get($flat, 'planFile', $flat->getPlan());
        $view->plan3d = $this->fileUrlHelper->get($flat, 'plan3dFile', $flat->getPlan3d());
        $view->planUrl = $flat->getPlanUrl();
        $view->pdf = $this->pdfManager->getFileURL($flat->getNumber(), $this->request);

        return $view;
    }

    /**
     * @param Floor[] $floors
     * @return FlatVisualFloorView[]
     */
    protected function getFloorsSummary($floors){
        $result = [];
        $rooms = Flat::getRoomsChoices();

        foreach ($floors as $floor){
            foreach ($rooms as $room => $name){
                $types[$room] = [
                    'quantity' => 0,
                    'minPrice' => null
                ];
            }
            $floorView = new FlatVisualFloorView();
            $floorView->number = $floor->getNumber();
            $inSales = 0;
            foreach ($floor->getFlats() as $flat){
                if(isset($types[$flat->getRooms()]) && $flat->isInSales()){
                    $types[$flat->getRooms()]['quantity'] += 1;
                    if($types[$flat->getRooms()]['minPrice'] == 0 || $types[$flat->getRooms()]['minPrice'] > $flat->getPrice()){
                        $types[$flat->getRooms()]['minPrice'] = $flat->getPrice();
                    }

                    $inSales++;
                }
            }
            $floorView->inSales = $inSales;
            foreach ($types as $type => $typeData){
                $flatView = new FlatVisualFloorFlatView();
                $floorView->flats[] = $flatView;
                $flatView->type = $type;
                $flatView->quantity = $typeData['quantity'];
                $flatView->minPrice = $typeData['minPrice'];
            }
            $result[] = $floorView;
        }

        return $result;
    }
}