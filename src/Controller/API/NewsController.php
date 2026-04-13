<?php


namespace App\Controller\API;

use App\Entity\Form\NewsList;
use App\Entity\Form\NewsSingle;
use App\Entity\News;
use App\Form\NewsListType;
use App\Form\NewsSingleType;
use App\Repository\NewsRepository;
use App\Services\FileUrlHelper;
use App\View\NewsListItemView;
use App\View\NewsListView;
use App\View\NewsSingleView;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewsController
 * @package App\Controller\API
 *
 * @Route("/api/news",name="api_news_")
 */
class NewsController extends AbstractController
{
    /**
     * @var FileUrlHelper
     */
    private FileUrlHelper $fileUrlHelper;

    public function __construct(FileUrlHelper $fileUrlHelper)
    {
        $this->fileUrlHelper = $fileUrlHelper;
    }

    /**
     * @OA\Get(
     *     tags={"Новости"},
     *     path="/api/news",
     *     summary="Список новостей",
     *     @OA\Parameter(ref="#/components/parameters/limit"),
     *     @OA\Parameter(ref="#/components/parameters/offset"),
     *     @OA\Response(
     *       response=200,
     *       headers={
     *           @OA\Header(
     *               header="X-Total-Count",
     *               description="Общее количество новостей",
     *               @OA\Schema(type="number", format="integer", example=15)
     *           )
     *       },
     *       description="Список новостей",
     *       @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/NewsListItem"))
     *     )
     * )
     * @param Request $request
     * @param NewsRepository $newsRepository
     *
     * @Route("", name="list")
     * @return JsonResponse
     */
    public function list(Request $request, NewsRepository $newsRepository){
        $entity = new NewsList();
        $form = $this->createForm(NewsListType::class, $entity);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $news = $newsRepository->getList($entity);
                $views = $this->populateListView($news);
                $response = new JsonResponse($views);
                $response->headers->set('X-Total-Count', $newsRepository->count([]));
                return $response;
            }
        }

        throw new BadRequestHttpException();
    }

    /**
     * @OA\Get(
     *   tags={"Новости"},
     *   path="/api/news/{path}",
     *   summary="Одиночная новость со списком последних",
     *   @OA\Response(
     *     response=200,
     *     description="Одиночная новость со списком последних",
     *     @OA\JsonContent(ref="#/components/schemas/NewsSingle")
     *   )
     * )
     * @param Request $request
     * @param NewsRepository $newsRepository
     *
     * @param $path
     * @return JsonResponse
     * @Route("/{path}", name="single")
     */
    public function single(Request $request, NewsRepository $newsRepository, $path){
        $news = $newsRepository->findOneBy(['path' => $path]);
        if(is_null($news)){
            throw $this->createNotFoundException();
        }

        $list = $newsRepository->findNewest(5, $news);
        $view = $this->populateSingleView($news, $list);

        return new JsonResponse($view);
    }

    /**
     * @param News[] $news
     * @return array
     */
    protected function populateListView($news){
        $result = [];
        foreach ($news as $n){
            $view = new NewsListItemView();
            $result[] = $view;
            $view->id = $n->getId();
            $view->path = $n->getPath();
            $view->date = $n->getDate() ? $n->getDate()->format('Y-m-d') : null;
            $view->description = $n->getDescription();
            $view->header = $n->getHeader();
        }
        return $result;
    }

    /**
     * @param News $news
     * @param News[] $list
     * @return NewsSingleView
     */
    protected function populateSingleView(News $news, $list){
        $view = new NewsSingleView();
        $view->id = $news->getId();
        $view->path = $news->getPath();
        $view->date = $news->getDate() ? $news->getDate()->format('Y-m-d') : null;
        $view->description = $news->getDescription();
        $view->header = $news->getHeader();
        $view->text = $news->getText();
        $view->image = $this->fileUrlHelper->get($news, 'imageFile', $news->getImage());

        $view->list = [];
        foreach ($list as $n){
            $itemView = new NewsListItemView();
            $view->list[] = $itemView;
            $itemView->id = $n->getId();
            $itemView->path = $n->getPath();
            $itemView->date = $n->getDate() ? $n->getDate()->format('Y-m-d') : null;
            $itemView->description = $n->getDescription();
            $itemView->header = $n->getHeader();
        }

        return $view;
    }

}