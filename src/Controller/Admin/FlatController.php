<?php

namespace App\Controller\Admin;

use App\Entity\Flat;
use App\Entity\Form\Search\FlatSearch;
use App\Form\Admin\FlatType;
use App\Form\Search\FlatSearchType;
use App\Repository\FlatRepository;
use App\Services\FlatExport;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Services\FormErrorsParser;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;

/**
 * @Route("/admin/flat", name="admin_flat_")
 */
class FlatController extends AbstractCrudController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @param FlatRepository $flatRepository
     * @return Response
     */
    public function index(FlatRepository $flatRepository): Response
    {
        $searchEntity = new FlatSearch();
        $searchForm = $this->createForm(FlatSearchType::class, $searchEntity);
        $searchForm->handleRequest($this->request);
        if($searchForm->isSubmitted()){
            if($searchForm->isValid()){
                $flats = $flatRepository->findBySearchForm($searchEntity);
            }
            else{
                $searchEntity->setSort('number');
                $flats = $flatRepository->findBySearchForm($searchEntity);
            }
        }
        else{
            $searchEntity->setSort('number');
            $flats = $flatRepository->findBySearchForm($searchEntity);
        }
        return $this->render('admin/flat/index.html.twig', [
            'flats' => $flats,
            'search' => $searchForm->createView(),
            'searchEntity' => $searchEntity
        ]);
    }

    /**
     * @Route("/export", name="export", methods={"GET"})
     * @param FlatExport $export
     * @param FlatRepository $repository
     * @return BinaryFileResponse
     * @throws Exception
     */
    public function export(FlatExport $export, FlatRepository $repository){
        $flats = $repository->findBy([],['number' => 'asc']);

        $file = $export->xlsx($flats);
        if($file){
            return $this->file($file, $export->getXlsFilename(), ResponseHeaderBag::DISPOSITION_INLINE);
        }
        else{
            throw new \Exception();
        }
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @return Response
     */
    public function new(FormErrorsParser $formErrorsParser): Response
    {
        $flat = new Flat();
        $form = $this->createForm(FlatType::class, $flat);

        $response = $this->handleForm($form, $formErrorsParser, $flat);

        if(is_null($response)){
            $response = $this->render('admin/flat/new.html.twig', [
                'flat' => $flat,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Flat $flat
     * @return Response
     */
    public function show(Flat $flat): Response
    {
        return $this->render('admin/flat/show.html.twig', [
            'flat' => $flat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param FormErrorsParser $formErrorsParser
     * @param Flat $flat
     * @return Response
     */
    public function edit(FormErrorsParser $formErrorsParser, Flat $flat): Response
    {
        $form = $this->createForm(FlatType::class, $flat);

        $response = $this->handleForm($form, $formErrorsParser, $flat);

        if(is_null($response)){
            $response = $this->render('admin/flat/edit.html.twig', [
                'flat' => $flat,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Flat $flat
     * @return Response
     */
    public function delete(Flat $flat): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($flat);
        $entityManager->flush();

        return $this->redirectToRoute('admin_flat_index');
    }

    /**
     * @param FormInterface $form
     * @param FormErrorsParser $formErrorsParser
     * @param Flat $entity
     * @return Response|null
     */
    protected function handleForm(FormInterface $form, FormErrorsParser $formErrorsParser, Flat $entity): ?Response
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
                        'redirect' => $this->generateUrl("admin_flat_index"),
                    ]);
                } else {
                    $response = new RedirectResponse(
                        $this->generateUrl("admin_flat_index")
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
