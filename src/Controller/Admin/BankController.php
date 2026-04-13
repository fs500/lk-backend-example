<?php

namespace App\Controller\Admin;

use App\Entity\Bank;
use App\Form\Admin\BankType;
use App\Repository\BankRepository;
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
 * @Route("/admin/bank", name="admin_bank_")
 */
class BankController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param BankRepository $bankRepository
     * @return Response
     */
    public function index(BankRepository $bankRepository): Response
    {
        return $this->render('admin/bank/index.html.twig', [
            'banks' => $bankRepository->findBy([],['sort' => 'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $bank = new Bank();
        $form = $this->createForm(BankType::class, $bank);

        $response = $this->handleForm($form, $formErrorsParser, $bank);

        if(is_null($response)){
            $response = $this->render('admin/bank/new.html.twig', [
                'bank' => $bank,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Bank $bank
     * @return Response
     */
    public function show(Bank $bank): Response
    {
        return $this->render('admin/bank/show.html.twig', [
            'bank' => $bank,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param Bank $bank
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, Bank $bank): Response
    {
        $form = $this->createForm(BankType::class, $bank);

        $response = $this->handleForm($form, $formErrorsParser, $bank);

        if(is_null($response)){
            $response = $this->render('admin/bank/edit.html.twig', [
                'bank' => $bank,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Bank $bank
     * @return Response
     */
    public function delete(Bank $bank): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($bank);
        $entityManager->flush();

        return $this->redirectToRoute('admin_bank_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Bank $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Bank $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_bank_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_bank_index")
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
