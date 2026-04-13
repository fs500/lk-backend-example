<?php

namespace App\Controller\Admin;

use App\Entity\Contacts;
use App\Entity\Page;
use App\Entity\PageCommerce;
use App\Form\Admin\ContactsType;
use App\Form\Admin\PageCommerceType;
use App\Form\Admin\PageHowToBuyType;
use App\Form\Admin\PageIndexType;
use App\Form\Admin\PageLocationType;
use App\Repository\ContactsRepository;
use App\Repository\PageRepository;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Services\FormErrorsParser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;

/**
 * @Route("/admin/page", name="admin_page_")
 */
class PageController extends AbstractCrudController
{
    /**
     * @Route("/index", name="index", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function index(FormErrorsParser $formErrorsParser): Response
    {
        $page = $this->getPageByType(Page::TYPE_INDEX);

        $form = $this->getFormByType(Page::TYPE_INDEX, $page);

        $response = $this->handleForm($form, $formErrorsParser, $page, "admin_page_index");

        if(is_null($response)){
            $response = $this->render('admin/page/index.html.twig', [
                'page' => $page,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/how_to_buy", name="how_to_buy", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function howToBuy(FormErrorsParser $formErrorsParser): Response
    {
        $page = $this->getPageByType(Page::TYPE_HOW_TO_BUY);

        $form = $this->getFormByType(Page::TYPE_HOW_TO_BUY, $page);

        $response = $this->handleForm($form, $formErrorsParser, $page, "admin_page_how_to_buy");

        if(is_null($response)){
            $response = $this->render('admin/page/how_to_buy.html.twig', [
                'page' => $page,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/commerce", name="commerce", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function commerce(FormErrorsParser $formErrorsParser): Response
    {
        $page = $this->getPageByType(Page::TYPE_COMMERCE);

        $form = $this->getFormByType(Page::TYPE_COMMERCE, $page);

        $response = $this->handleForm($form, $formErrorsParser, $page, "admin_page_commerce");

        if(is_null($response)){
            $response = $this->render('admin/page/commerce.html.twig', [
                'page' => $page,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/contacts", name="contacts", methods={"GET","POST"})
     * @param ContactsRepository $repository
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function contacts(ContactsRepository $repository, FormErrorsParser $formErrorsParser): Response
    {
        $page = $repository->findOneBy([]);

        if(is_null($page)){
            $page = new Contacts();
        }

        $form = $this->createForm(ContactsType::class, $page);

        $response = $this->handleForm($form, $formErrorsParser, $page, "admin_page_contacts");

        if(is_null($response)){
            $response = $this->render('admin/page/contacts.html.twig', [
                'page' => $page,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/location", name="location", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function location(FormErrorsParser $formErrorsParser){
        $page = $this->getPageByType(Page::TYPE_LOCATION);

        $form = $this->getFormByType(Page::TYPE_LOCATION, $page);

        $response = $this->handleForm($form, $formErrorsParser, $page, "admin_page_location");

        if(is_null($response)){
            $response = $this->render('admin/page/location.html.twig', [
                'page' => $page,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    protected function getPageByType($type){
        /** @var PageRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Page::class);
        $types = Page::getTypeChoices();
        if(array_key_exists($type, $types)){
            $page = $repository->findOneBy(['type' => $type]);
            if(is_null($page)){
                $page = new Page();
                $page->setType($type);
            }
        }
        else{
            throw new BadRequestHttpException();
        }

        return $page;
    }

    protected function getFormByType($type, Page $entity){
        $types = Page::getTypeChoices();
        if(array_key_exists($type, $types)){
            switch ($type){
                case Page::TYPE_INDEX:
                    $form = $this->createForm(PageIndexType::class, $entity);
                    break;
                case Page::TYPE_HOW_TO_BUY:
                    $form = $this->createForm(PageHowToBuyType::class, $entity);
                    break;
                case Page::TYPE_COMMERCE:
                    $form = $this->createForm(PageCommerceType::class, $entity);
                    break;
                case Page::TYPE_LOCATION:
                    $form = $this->createForm(PageLocationType::class, $entity);
                    break;
            }
        }
        else{
            throw new BadRequestHttpException();
        }

        return $form;
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Page|Contacts $entity
     * @param $route
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, $entity, $route): ?Response
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
                        'redirect' => $this->generateUrl($route),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl($route)
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
        //dump($this->request->attributes->get('_controller'));
        //TODO Отредактируйте параметры для подсветки пункта меню DashboardController
        return
            $controllerMenuDto
                ->setController(self::class)
                ->setParams([]) //например ['id' => $this->request->get('example_id')]
                ->setQuery([])  //например ['example_id' => $this->request->get('example_id')]
                ->setActionsByRoute([
                    'admin_page_index' => ['index'],
                    'admin_page_how_to_buy' => ['howToBuy'],
                    'admin_page_commerce' => ['commerce'],
                    'admin_page_contacts' => ['contacts'],
                ])
            ;
    }
}
