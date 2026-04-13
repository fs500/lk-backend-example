<?php

namespace App\Controller\Admin;

use App\Entity\SettingGroup;
use App\Form\Admin\SettingGroupType;
use App\Repository\SettingGroupRepository;
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
 * @Route("/admin/setting", name="admin_setting_")
 */
class SettingController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param SettingGroupRepository $settingGroupRepository
     * @return Response
     */
    public function index(SettingGroupRepository $settingGroupRepository): Response
    {
        return $this->render('admin/setting/index.html.twig', [
            'setting_groups' => $settingGroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param SettingGroup $settingGroup
     * @return Response
     */
    public function show(SettingGroup $settingGroup): Response
    {
        return $this->render('admin/setting/show.html.twig', [
            'setting_group' => $settingGroup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param FormErrorsParser $formErrorsParser
     * @param SettingGroup $settingGroup
     * @return Response
     */
    public function edit(Request $request, FormErrorsParser $formErrorsParser, SettingGroup $settingGroup): Response
    {
        $form = $this->createForm(SettingGroupType::class, $settingGroup);

        $response = $this->handleForm($request, $form, $formErrorsParser, $settingGroup);

        if(is_null($response)){
            $response = $this->render('admin/setting/edit.html.twig', [
                'settingGroup' => $settingGroup,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param SettingGroup $entity
     * @return Response|null
     */
    protected function handleForm(Request $request, FormInterface $form, FormErrorsParser $formErrorsParser, SettingGroup $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_setting_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_setting_index")
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
        return $controllerMenuDto->setController(self::class);
    }
}
