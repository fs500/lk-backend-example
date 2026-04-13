<?php


namespace App\Controller\API;


use App\Entity\Metatag;
use App\View\MetatagView;
use Eyetronic\SymfonyMetatagBundle\Entity\Form\MetatagSearch;
use Eyetronic\SymfonyMetatagBundle\Form\Api\MetatagUrlType;
use Eyetronic\SymfonyMetatagBundle\Services\MetatagSearchManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class MetatagController extends AbstractController
{

    /**
     * @return JsonResponse
     * @Route("/api/metatag", name="metatag")
     *
     * @OA\Get(
     *     tags={"Метатеги"},
     *     path="/api/metatag",
     *     summary="Метатеги для страницы по запрошенному URI",
     *     @OA\Parameter(ref="#/components/parameters/metatag_uri"),
     *     @OA\Response(
     *       response=200,
     *       description="Метатеги запрошенной страницы",
     *       @OA\JsonContent(ref="#/components/schemas/Metatag")
     *     )
     * )
     *
     * @OA\Parameter(
     *     parameter="metatag_uri",
     *     name="url",
     *     description="URI страницы",
     *     example="/contacts",
     *     @OA\Schema(
     *       type="string"
     *     ),
     *     in="query",
     *     required=true
     * )
     */
    public function search(MetatagSearchManager $manager, Request $request){
        $entity = new MetatagSearch();
        $form = $this->createForm(MetatagUrlType::class, $entity);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                /** @var Metatag $metatags */
                $metatags = $manager->findOneByUrl($entity);
                if(!is_null($metatags)){
                    $view = new MetatagView();
                    $view->title = $metatags->getTitle();
                    $view->keywords = $metatags->getKeywords();
                    $view->description = $metatags->getDescription();
                    return new JsonResponse($view);
                }
                else{
                    throw $this->createNotFoundException();
                }
            }
        }

        throw new BadRequestHttpException();
    }
}