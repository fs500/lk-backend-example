<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Form\Admin\DocumentType;
use App\Repository\DocumentRepository;
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
 * @Route("/admin/document", name="admin_document_")
 */
class DocumentController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param DocumentRepository $documentRepository
     * @return Response
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('admin/document/index.html.twig', [
            'documents' => $documentRepository->findBy([], ['date' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);

        $response = $this->handleForm($form, $formErrorsParser, $document);

        if(is_null($response)){
            $response = $this->render('admin/document/new.html.twig', [
                'document' => $document,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Document $document
     * @return Response
     */
    public function show(Document $document): Response
    {
        return $this->render('admin/document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param Document $document
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);

        $response = $this->handleForm($form, $formErrorsParser, $document);

        if(is_null($response)){
            $response = $this->render('admin/document/edit.html.twig', [
                'document' => $document,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Document $document
     * @return Response
     */
    public function delete(Document $document): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($document);
        $entityManager->flush();

        return $this->redirectToRoute('admin_document_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Document $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Document $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_document_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_document_index")
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
