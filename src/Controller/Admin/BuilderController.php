<?php

namespace App\Controller\Admin;

use App\Entity\Builder;
use App\Form\Admin\BuilderType;
use App\Repository\BuilderRepository;
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
 * @Route("/admin/builder", name="admin_builder_")
 */
class BuilderController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET","POST"})
     * @param BuilderRepository $builderRepository
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function index(BuilderRepository $builderRepository, FormErrorsParser $formErrorsParser): Response
    {
        $builder = $builderRepository->findOneBy([]);
        if(is_null($builder)){
            $builder = new Builder();
        }
        $form = $this->createForm(BuilderType::class, $builder);

        $response = $this->handleForm($form, $formErrorsParser, $builder);

        if(is_null($response)){
            $response = $this->render('admin/builder/edit.html.twig', [
                'builder' => $builder,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Builder $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Builder $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_builder_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_builder_index")
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
