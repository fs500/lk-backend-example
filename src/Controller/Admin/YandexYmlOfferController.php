<?php

namespace App\Controller\Admin;

use App\Entity\YandexYmlOffer;
use App\Form\Admin\YandexYmlOfferType;
use App\Repository\YandexYmlOfferRepository;
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
 * @Route("/admin/yandex/yml/offer", name="admin_yandex_yml_offer_")
 */
class YandexYmlOfferController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param YandexYmlOfferRepository $yandexYmlOfferRepository
     * @return Response
     */
    public function index(YandexYmlOfferRepository $yandexYmlOfferRepository): Response
    {
        return $this->render('admin/yandex_yml_offer/index.html.twig', [
            'yandex_yml_offers' => $yandexYmlOfferRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $yandexYmlOffer = new YandexYmlOffer();
        $form = $this->createForm(YandexYmlOfferType::class, $yandexYmlOffer);

        $response = $this->handleForm($form, $formErrorsParser, $yandexYmlOffer);

        if(is_null($response)){
            $response = $this->render('admin/yandex_yml_offer/new.html.twig', [
                'yandexYmlOffer' => $yandexYmlOffer,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param YandexYmlOffer $yandexYmlOffer
     * @return Response
     */
    public function show(YandexYmlOffer $yandexYmlOffer): Response
    {
        return $this->render('admin/yandex_yml_offer/show.html.twig', [
            'yandex_yml_offer' => $yandexYmlOffer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param YandexYmlOffer $yandexYmlOffer
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, YandexYmlOffer $yandexYmlOffer): Response
    {
        $form = $this->createForm(YandexYmlOfferType::class, $yandexYmlOffer);

        $response = $this->handleForm($form, $formErrorsParser, $yandexYmlOffer);

        if(is_null($response)){
            $response = $this->render('admin/yandex_yml_offer/edit.html.twig', [
                'yandexYmlOffer' => $yandexYmlOffer,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param YandexYmlOffer $yandexYmlOffer
     * @return Response
     */
    public function delete(YandexYmlOffer $yandexYmlOffer): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($yandexYmlOffer);
        $entityManager->flush();

        return $this->redirectToRoute('admin_yandex_yml_offer_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param YandexYmlOffer $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, YandexYmlOffer $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_yandex_yml_offer_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_yandex_yml_offer_index")
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
