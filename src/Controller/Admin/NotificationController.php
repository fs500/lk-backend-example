<?php

namespace App\Controller\Admin;

use App\Entity\Notification;
use App\Form\Admin\NotificationType;
use App\Repository\NotificationRepository;
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
 * @Route("/admin/notification", name="admin_notification_")
 */
class NotificationController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param NotificationRepository $notificationRepository
     * @return Response
     */
    public function index(NotificationRepository $notificationRepository): Response
    {
        return $this->render('admin/notification/index.html.twig', [
            'notifications' => $notificationRepository->findBy([],['dateStart' => 'asc']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);

        $response = $this->handleForm($form, $formErrorsParser, $notification);

        if(is_null($response)){
            $response = $this->render('admin/notification/new.html.twig', [
                'notification' => $notification,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Notification $notification
     * @return Response
     */
    public function show(Notification $notification): Response
    {
        return $this->render('admin/notification/show.html.twig', [
            'notification' => $notification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param Notification $notification
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, Notification $notification): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);

        $response = $this->handleForm($form, $formErrorsParser, $notification);

        if(is_null($response)){
            $response = $this->render('admin/notification/edit.html.twig', [
                'notification' => $notification,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Notification $notification
     * @return Response
     */
    public function delete(Notification $notification): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($notification);
        $entityManager->flush();

        return $this->redirectToRoute('admin_notification_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Notification $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Notification $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_notification_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_notification_index")
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
