<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;
use Eyetronic\EyeAdminBundle\Services\FormErrorsParser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/user", name="admin_user_")
 */
class UserController extends AbstractCrudController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(RequestStack $requestStack, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($requestStack);
        $this->encoder = $encoder;
    }

    /**
     * @Route("", name="index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
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
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $response = $this->handleForm($request, $form, $formErrorsParser, $user);

        if(is_null($response)){
            $response = $this->render('admin/user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/show/{id}", name="show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param FormErrorsParser $formErrorsParser
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, FormErrorsParser $formErrorsParser, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $response = $this->handleForm($request, $form, $formErrorsParser, $user);

        if(is_null($response)){
            $response = $this->render('admin/user/edit.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if($this->getUser() == $user){
            throw $this->createAccessDeniedException();
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param User $entity
     * @return Response|null
     */
    protected function handleForm(Request $request, FormInterface $form, FormErrorsParser $formErrorsParser, User $entity): ?Response
    {
        $response = null;
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                if(!empty($entity->getNewPassword())){
                    $entity->setPassword($this->encoder->encodePassword($entity, $entity->getNewPassword()));
                }
                if(!$em->contains($entity)){
                    $em->persist($entity);
                }
                $em->flush();

                if ($request->isXmlHttpRequest()) {
                    $response = new JsonResponse([
                        'success' => true,
                        'redirect' => $this->generateUrl("admin_user_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_user_index")
                    );
                }
            }  elseif ($request->isXmlHttpRequest()) {
                $errors = $formErrorsParser->parseErrors($form);

                $response = new JsonResponse(['errors' => $errors], 400);
            }
        }

        return $response;
    }

    public function getMenuControllerParams(ControllerMenuDto $controllerMenuDto): ControllerMenuDto
    {
        return $controllerMenuDto->setController(self::class);
    }
}
