<?php

namespace App\Controller\Admin;

use App\Entity\YandexYmlSet;
use App\Form\Admin\YandexYmlSetType;
use App\Repository\YandexYmlSetRepository;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Services\FormErrorsParser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;

/**
 * @Route("/admin/yandex_yml_set", name="admin_yandex_yml_set_")
 */
class YandexYmlSetController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param YandexYmlSetRepository $yandexYmlSetRepository
     * @return Response
     */
    public function index(YandexYmlSetRepository $yandexYmlSetRepository): Response
    {
        return $this->render('admin/yandex_yml_set/index.html.twig', [
            'yandex_yml_sets' => $yandexYmlSetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $yandexYmlSet = new YandexYmlSet();
        $form = $this->createForm(YandexYmlSetType::class, $yandexYmlSet);

        $response = $this->handleForm($form, $formErrorsParser, $yandexYmlSet);

        if(is_null($response)){
            $response = $this->render('admin/yandex_yml_set/new.html.twig', [
                'yandexYmlSet' => $yandexYmlSet,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param YandexYmlSet $yandexYmlSet
     * @return Response
     */
    public function show(YandexYmlSet $yandexYmlSet): Response
    {
        return $this->render('admin/yandex_yml_set/show.html.twig', [
            'yandex_yml_set' => $yandexYmlSet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param YandexYmlSet $yandexYmlSet
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, YandexYmlSet $yandexYmlSet): Response
    {
        $form = $this->createForm(YandexYmlSetType::class, $yandexYmlSet);

        $response = $this->handleForm($form, $formErrorsParser, $yandexYmlSet);

        if(is_null($response)){
            $response = $this->render('admin/yandex_yml_set/edit.html.twig', [
                'yandexYmlSet' => $yandexYmlSet,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param YandexYmlSet $yandexYmlSet
     * @return Response
     */
    public function delete(YandexYmlSet $yandexYmlSet): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($yandexYmlSet);
        $entityManager->flush();

        return $this->redirectToRoute('admin_yandex_yml_set_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param YandexYmlSet $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, YandexYmlSet $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_yandex_yml_set_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_yandex_yml_set_index")
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
                ->setActionsByRoute([]) //например ['admin_route_name' => ['actionIndex', 'actionView']]
            ;
    }
}
