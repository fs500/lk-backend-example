<?php


namespace App\Controller\Admin;


use App\Entity\Form\UpdateFlat;
use App\Form\Admin\UpdateFlatType;
use App\Repository\FlatRepository;
use App\Services\FlatUpdater;
use Eyetronic\EyeAdminBundle\Controller\AbstractCrudController;
use Eyetronic\EyeAdminBundle\Dto\ControllerMenuDto;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UpdateFlatController extends AbstractCrudController
{

    /**
     * @Route("/admin/update/flat", name="admin_update_flat")
     */
    public function index(FlatUpdater $updater){
        $entity = new UpdateFlat();
        $form = $this->createForm(UpdateFlatType::class, $entity);
        $form->handleRequest($this->request);
        if($form->isSubmitted()){
            if($form->isValid()){
                $data = [
                    'success' => $updater->fromExcel($entity->getDataFile()),
                    'parserErrors' => $updater->getErrors(),
                    'updatedFlats' => $updater->getUpdatedRows(),
                ];
                $response = new JsonResponse($data);
            }
            else{
                $response =  $this->render('admin/updateFlat/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        }
        else{
            $response = $this->render('admin/updateFlat/index.html.twig', [
                'form' => $form->createView(),
            ]);
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