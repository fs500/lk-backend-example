<?php

namespace App\Controller\Admin;

use App\Entity\Floor;
use App\Form\Admin\FloorType;
use App\Repository\FloorRepository;
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
 * @Route("/admin/floor", name="admin_floor_")
 */
class FloorController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param FloorRepository $floorRepository
     * @return Response
     */
    public function index(FloorRepository $floorRepository): Response
    {
        return $this->render('admin/floor/index.html.twig', [
            'floors' => $floorRepository->findBy([], ['number' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $floor = new Floor();
        $form = $this->createForm(FloorType::class, $floor);

        $response = $this->handleForm($form, $formErrorsParser, $floor);

        if(is_null($response)){
            $response = $this->render('admin/floor/new.html.twig', [
                'floor' => $floor,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Floor $floor
     * @return Response
     */
    public function show(Floor $floor): Response
    {
        return $this->render('admin/floor/show.html.twig', [
            'floor' => $floor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param Floor $floor
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, Floor $floor): Response
    {
        $form = $this->createForm(FloorType::class, $floor);

        $response = $this->handleForm($form, $formErrorsParser, $floor);

        if(is_null($response)){
            $response = $this->render('admin/floor/edit.html.twig', [
                'floor' => $floor,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Floor $floor
     * @return Response
     */
    public function delete(Floor $floor): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($floor);
        $entityManager->flush();

        return $this->redirectToRoute('admin_floor_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Floor $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Floor $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_floor_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_floor_index")
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
