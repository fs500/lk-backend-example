<?php

namespace App\Controller\Admin;

use App\Entity\BuildingProgress;
use App\Form\Admin\BuildingProgressType;
use App\Repository\BuildingProgressRepository;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;
use Eyetronic\EyeAdminBundle\Services\FormErrorsParser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/building_progress", name="admin_building_progress_")
 */
class BuildingProgressController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param BuildingProgressRepository $buildingProgressRepository
     * @param Request $request
     * @return Response
     */
    public function index(BuildingProgressRepository $buildingProgressRepository, Request $request): Response
    {
        return $this->render('admin/building_progress/index.html.twig', [
            'building_progresses' => $buildingProgressRepository->findBy([],['date' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(Request $request, FormErrorsParser $formErrorsParser): Response
    {
        $buildingProgress = new BuildingProgress();
        $form = $this->createForm(BuildingProgressType::class, $buildingProgress);

        $response = $this->handleForm($request, $form, $formErrorsParser, $buildingProgress);

        if(is_null($response)){
            $response = $this->render('admin/building_progress/new.html.twig', [
                'buildingProgress' => $buildingProgress,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param BuildingProgress $buildingProgress
     * @param Request $request
     * @return Response
     */
    public function show(BuildingProgress $buildingProgress, Request $request): Response
    {
        return $this->render('admin/building_progress/show.html.twig', [
            'building_progress' => $buildingProgress,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param FormErrorsParser $formErrorsParser
     * @param BuildingProgress $buildingProgress
     * @return Response
     */
    public function edit(Request $request, FormErrorsParser $formErrorsParser, BuildingProgress $buildingProgress): Response
    {

        $form = $this->createForm(BuildingProgressType::class, $buildingProgress);

        $response = $this->handleForm($request, $form, $formErrorsParser, $buildingProgress);

        if(is_null($response)){
            $response = $this->render('admin/building_progress/edit.html.twig', [
                'buildingProgress' => $buildingProgress,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param BuildingProgress $buildingProgress
     * @return Response
     */
    public function delete(Request $request, BuildingProgress $buildingProgress): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($buildingProgress);
        $entityManager->flush();

        return $this->redirectToRoute('admin_building_progress_index');
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param BuildingProgress $entity
     * @return Response|null
     */
    protected function handleForm(Request $request, FormInterface $form, FormErrorsParser $formErrorsParser, BuildingProgress $entity): ?Response
    {
        $response = null;
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                if(!$em->contains($entity)){
                    $em->persist($entity);
                }
                $em->flush();

                if ($request->isXmlHttpRequest()) {
                    $response = new JsonResponse([
                        'success' => true,
                        'redirect' => $this->generateUrl("admin_building_progress_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_building_progress_index")
                    );
                }
            } elseif ($request->isXmlHttpRequest()) {
                $errors = $formErrorsParser->parseErrors($form);
                $response = new JsonResponse(['errors' => $errors], 400);
            }
        }

        return $response;
    }

    public function getMenuControllerParams(ControllerMenuDto $controllerMenuDto): ControllerMenuDto
    {
        return
            $controllerMenuDto
                ->setController(self::class)
                ->setParams([])
            ;
    }
}
