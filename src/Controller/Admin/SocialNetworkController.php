<?php

namespace App\Controller\Admin;

use App\Entity\SocialNetwork;
use App\Form\Admin\SocialNetworkType;
use App\Repository\SocialNetworkRepository;
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
 * @Route("/admin/social_network", name="admin_social_network_")
 */
class SocialNetworkController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param SocialNetworkRepository $socialNetworkRepository
     * @return Response
     */
    public function index(SocialNetworkRepository $socialNetworkRepository): Response
    {
        return $this->render('admin/social_network/index.html.twig', [
            'social_networks' => $socialNetworkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $socialNetwork = new SocialNetwork();
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);

        $response = $this->handleForm($form, $formErrorsParser, $socialNetwork);

        if(is_null($response)){
            $response = $this->render('admin/social_network/new.html.twig', [
                'socialNetwork' => $socialNetwork,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param SocialNetwork $socialNetwork
     * @return Response
     */
    public function show(SocialNetwork $socialNetwork): Response
    {
        return $this->render('admin/social_network/show.html.twig', [
            'social_network' => $socialNetwork,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param SocialNetwork $socialNetwork
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, SocialNetwork $socialNetwork): Response
    {
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);

        $response = $this->handleForm($form, $formErrorsParser, $socialNetwork);

        if(is_null($response)){
            $response = $this->render('admin/social_network/edit.html.twig', [
                'socialNetwork' => $socialNetwork,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param SocialNetwork $socialNetwork
     * @return Response
     */
    public function delete(SocialNetwork $socialNetwork): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($socialNetwork);
        $entityManager->flush();

        return $this->redirectToRoute('admin_social_network_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param SocialNetwork $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, SocialNetwork $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_social_network_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_social_network_index")
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
