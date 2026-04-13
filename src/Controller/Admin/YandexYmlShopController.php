<?php

namespace App\Controller\Admin;

use App\Entity\YandexYmlShop;
use App\Form\Admin\YandexYmlShopType;
use App\Repository\YandexYmlShopRepository;
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
 * @Route("/admin/yandex_yml_shop", name="admin_yandex_yml_shop_")
 */
class YandexYmlShopController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param YandexYmlShopRepository $yandexYmlShopRepository
     * @return Response
     */
    public function index(YandexYmlShopRepository $yandexYmlShopRepository): Response
    {
        throw $this->createNotFoundException();
        return $this->render('admin/yandex_yml_shop/index.html.twig', [
            'yandex_yml_shops' => $yandexYmlShopRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        throw $this->createNotFoundException();
        $yandexYmlShop = new YandexYmlShop();
        $form = $this->createForm(YandexYmlShopType::class, $yandexYmlShop);

        $response = $this->handleForm($form, $formErrorsParser, $yandexYmlShop);

        if(is_null($response)){
            $response = $this->render('admin/yandex_yml_shop/new.html.twig', [
                'yandexYmlShop' => $yandexYmlShop,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     * @param YandexYmlShop $yandexYmlShop
     * @return Response
     */
    public function show(YandexYmlShop $yandexYmlShop): Response
    {
        throw $this->createNotFoundException();
        return $this->render('admin/yandex_yml_shop/show.html.twig', [
            'yandex_yml_shop' => $yandexYmlShop,
        ]);
    }

    /**
     * @Route("/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser): Response
    {
        $yandexYmlShop = $this->getDoctrine()->getManager()->find(YandexYmlShop::class, 1);
        $form = $this->createForm(YandexYmlShopType::class, $yandexYmlShop);

        $response = $this->handleForm($form, $formErrorsParser, $yandexYmlShop);

        if(is_null($response)){
            $response = $this->render('admin/yandex_yml_shop/edit.html.twig', [
                'yandexYmlShop' => $yandexYmlShop,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param YandexYmlShop $yandexYmlShop
     * @return Response
     */
    public function delete(YandexYmlShop $yandexYmlShop): Response
    {
        throw $this->createNotFoundException();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($yandexYmlShop);
        $entityManager->flush();

        return $this->redirectToRoute('admin_yandex_yml_shop_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param YandexYmlShop $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, YandexYmlShop $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_yandex_yml_shop_edit"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_yandex_yml_shop_edit")
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
