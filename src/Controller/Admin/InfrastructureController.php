<?php

namespace App\Controller\Admin;

use App\Entity\Infrastructure;
use App\Form\Admin\InfrastructureType;
use App\Repository\InfrastructureRepository;
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
 * @Route("/admin/infrastructure", name="admin_infrastructure_")
 */
class InfrastructureController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param InfrastructureRepository $infrastructureRepository
     * @return Response
     */
    public function index(InfrastructureRepository $infrastructureRepository): Response
    {
        return $this->render('admin/infrastructure/index.html.twig', [
            'infrastructures' => $infrastructureRepository->findBy([],['sort' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $infrastructure = new Infrastructure();
        $form = $this->createForm(InfrastructureType::class, $infrastructure);

        $response = $this->handleForm($form, $formErrorsParser, $infrastructure);

        if(is_null($response)){
            $response = $this->render('admin/infrastructure/new.html.twig', [
                'infrastructure' => $infrastructure,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Infrastructure $infrastructure
     * @return Response
     */
    public function show(Infrastructure $infrastructure): Response
    {
        return $this->render('admin/infrastructure/show.html.twig', [
            'infrastructure' => $infrastructure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param Infrastructure $infrastructure
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, Infrastructure $infrastructure): Response
    {
        $form = $this->createForm(InfrastructureType::class, $infrastructure);

        $response = $this->handleForm($form, $formErrorsParser, $infrastructure);

        if(is_null($response)){
            $response = $this->render('admin/infrastructure/edit.html.twig', [
                'infrastructure' => $infrastructure,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Infrastructure $infrastructure
     * @return Response
     */
    public function delete(Infrastructure $infrastructure): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($infrastructure);
        $entityManager->flush();

        return $this->redirectToRoute('admin_infrastructure_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Infrastructure $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Infrastructure $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_infrastructure_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_infrastructure_index")
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
