<?php

namespace App\Controller\Admin;

use App\Entity\Building;
use App\Form\Admin\BuildingType;
use App\Repository\BuildingRepository;
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
 * @Route("/admin/building", name="admin_building_")
 */
class BuildingController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET","POST"})
     * @param BuildingRepository $buildingRepository
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function index(BuildingRepository $buildingRepository, FormErrorsParser $formErrorsParser): Response
    {
        $building = $buildingRepository->findOneBy([]);
        if(is_null($building)){
            $building = new Building();
        }
        $form = $this->createForm(BuildingType::class, $building);

        $response = $this->handleForm($form, $formErrorsParser, $building);

        if(is_null($response)){
            $response = $this->render('admin/building/edit.html.twig', [
                'building' => $building,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Building $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Building $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_building_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_building_index")
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
