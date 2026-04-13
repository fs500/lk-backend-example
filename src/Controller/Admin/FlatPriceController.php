<?php

namespace App\Controller\Admin;

use App\Entity\FlatPrice;
use App\Form\Admin\FlatPriceType;
use App\Repository\FlatPriceRepository;
use App\Services\FlatPriceUpdater;
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
 * @Route("/admin/flat_price", name="admin_flat_price_")
 */
class FlatPriceController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param FlatPriceRepository $flatPriceRepository
     * @return Response
     */
    public function index(FlatPriceRepository $flatPriceRepository): Response
    {
        return $this->render('admin/flat_price/index.html.twig', [
            'flat_prices' => $flatPriceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $flatPrice = new FlatPrice();
        $form = $this->createForm(FlatPriceType::class, $flatPrice);

        $response = $this->handleForm($form, $formErrorsParser, $flatPrice);

        if(is_null($response)){
            $response = $this->render('admin/flat_price/new.html.twig', [
                'flatPrice' => $flatPrice,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
     * @param FlatPrice $flatPrice
     * @return Response
     */
    public function show(FlatPrice $flatPrice): Response
    {
        return $this->render('admin/flat_price/show.html.twig', [
            'flat_price' => $flatPrice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @param FormErrorsParser $formErrorsParser
     * @param FlatPrice $flatPrice
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, FlatPrice $flatPrice): Response
    {
        $form = $this->createForm(FlatPriceType::class, $flatPrice);

        $response = $this->handleForm($form, $formErrorsParser, $flatPrice);

        if(is_null($response)){
            $response = $this->render('admin/flat_price/edit.html.twig', [
                'flatPrice' => $flatPrice,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param FlatPrice $flatPrice
     * @return Response
     */
    public function delete(FlatPrice $flatPrice): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($flatPrice);
        $entityManager->flush();

        return $this->redirectToRoute('admin_flat_price_index');
    }

    /**
     * @Route("/refresh", name="refresh", methods={"GET"})
     * @param FlatPriceUpdater $updater
     * @return JsonResponse
     */
    public function refresh(FlatPriceUpdater $updater){
        $date = $updater->update();
        return new JsonResponse(['success' => true, 'date' => $date->format('d.m.Y H:i')]);
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param FlatPrice $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, FlatPrice $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_flat_price_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_flat_price_index")
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
