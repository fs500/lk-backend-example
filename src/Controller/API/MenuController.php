<?php


namespace App\Controller\API;


use App\Entity\Menu;
use App\Entity\SocialNetwork;
use App\Repository\MenuRepository;
use App\Repository\SocialNetworkRepository;
use App\Services\FileUrlHelper;
use App\Services\LinkHelper;
use App\View\LinkView;
use App\View\MenuItemView;
use App\View\MenuView;
use App\View\SocialNetworkView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;


/**
 * Class MenuController
 * @package App\Controller\API
 * @Route("/api/menu", name="api_menu_")
 */
class MenuController extends AbstractController
{

    /**
     * @var LinkHelper
     */
    protected $linkHelper;

    /**
     * @var FileUrlHelper
     */
    private FileUrlHelper $fileUrlHelper;

    public function __construct(LinkHelper $linkHelper, FileUrlHelper $fileUrlHelper)
    {
        $this->linkHelper = $linkHelper;
        $this->fileUrlHelper = $fileUrlHelper;
    }

    /**
     * @return JsonResponse
     *
     * @OA\Get(
     *     tags={"Меню"},
     *     path="/api/menu",
     *     summary="Меню",
     *     @OA\Response(
     *       response=200,
     *       description="Данные меню сайта",
     *       @OA\JsonContent(ref="#/components/schemas/Menu")
     *     )
     * )
     *
     * @Route("", "index")
     */
    public function index(MenuRepository $repository, SocialNetworkRepository $sRepository){
        /** @var Menu[] $items */
        $items = $repository->findBy([], ['sort' => 'ASC']);
        /** @var SocialNetwork[] $sItems */
        $sItems = $sRepository->findAll();

        $view = $this->populateMenuView($items, $sItems);
        return new JsonResponse($view);
    }

    /**
     * @param Menu[] $items
     * @param SocialNetwork[] $sItems
     * @return MenuView
     */
    protected function populateMenuView($items, $sItems){
        $view = new MenuView();
        foreach ($items as $item){
            $mView = new MenuItemView();
            $view->items[] = $mView;
            $mView->header = $item->getHeader();
            $mView->link = $this->linkHelper->get($item->getLink());
        }

        foreach ($sItems as $item){
            $sView = new SocialNetworkView();
            $view->socialNetwork[] = $sView;
            $sView->icon = $this->fileUrlHelper->get($item, 'iconFile', $item->getIcon());
            $sView->url = $item->getUrl();
        }

        return $view;
    }
}