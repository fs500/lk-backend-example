<?php

namespace App\Controller\Admin;

use App\Entity\PageInfrastructure;
use App\Form\Admin\PageInfrastructureType;
use App\Repository\PageInfrastructureRepository;
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
 * @Route("/admin/page_infrastructure", name="admin_page_infrastructure_")
 */
class PageInfrastructureController extends AbstractCrudController
{

    /**
     * @Route("", name="index")
     * @param FormErrorsParser $formErrorsParser
     * @param PageInfrastructureRepository $repository
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, PageInfrastructureRepository $repository): Response
    {
        $entity = $repository->findOneBy([]);
        if(is_null($entity)){
            $entity = new PageInfrastructure();
        }
        $form = $this->createForm(PageInfrastructureType::class, $entity);

        $response = $this->handleForm($form, $formErrorsParser, $entity);

        if(is_null($response)){
            $response = $this->render('admin/page_infrastructure/edit.html.twig', [
                'pageInfrastructure' => $entity,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param PageInfrastructure $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, PageInfrastructure $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_page_infrastructure_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_page_infrastructure_index")
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
