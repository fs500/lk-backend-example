<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\Admin\NewsType;
use App\Repository\NewsRepository;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Controller\CrudControllerInterface;
use Eyetronic\EyeAdminBundle\Services\FormErrorsParser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;

/**
 * @Route("/admin/news", name="admin_news_")
 */
class NewsController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('admin/news/index.html.twig', [
            'news' => $newsRepository->findBy([], ['date' => 'desc']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);

        $response = $this->handleForm($form, $formErrorsParser, $news);

        if(is_null($response)){
            $response = $this->render('admin/news/new.html.twig', [
                'news' => $news,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param News $news
     * @return Response
     */
    public function show(News $news): Response
    {
        return $this->render('admin/news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param News $news
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);

        $response = $this->handleForm($form, $formErrorsParser, $news);

        if(is_null($response)){
            $response = $this->render('admin/news/edit.html.twig', [
                'news' => $news,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param News $news
     * @return Response
     */
    public function delete(News $news): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute('admin_news_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param News $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, News $entity): ?Response
    {
        $response = null;
        $form->handleRequest($this->request);
        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                if(!$em->contains($entity)){
                    $em->persist($entity);
                }
                $em->flush();

                if ($this->request->isXmlHttpRequest()) {
                    $response = new JsonResponse([
                        'success' => true,
                        'redirect' => $this->generateUrl("admin_news_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_news_index")
                    );
                }
            } elseif ($this->request->isXmlHttpRequest()) {
                $errors = $formErrorsParser->parseErrors($form);
                $response = new JsonResponse(['errors' => $errors], 400);
            }
        }

        return $response;
    }

    public function getMenuControllerParams(ControllerMenuDto $controllerMenuDto): ControllerMenuDto
    {
        //TODO Отредактируйте параметры для подсветки пункта меню DashboardController
        return
            $controllerMenuDto
                ->setController(self::class)
                ->setParams([]) //например ['id' => $this->request->get('example_id')]
                ->setQuery([])  //например ['example_id' => $this->request->get('example_id')]
            ;
    }
}
