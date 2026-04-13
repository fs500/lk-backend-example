<?php


namespace App\Controller;


use App\Repository\FlatRepository;
use App\Services\FlatPDFManager;
use App\Services\SvgParser;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    /**
     * @var SvgParser
     */
    private $svgParser;

    public function __construct(SvgParser $svgParser)
    {
        $this->svgParser = $svgParser;
    }

    /**
     * @param FlatPDFManager $manager
     * @param $number
     * @return Response
     * @throws Exception
     * @Route("/{number}.pdf", name="pdf") //отключим роут
     */
    public function pdf(FlatPDFManager $manager, $number){
        $manager->renderFlat($number);

        return new BinaryFileResponse($manager->getFilename($number));
    }

    /**
     * @param $number
     * @param FlatRepository $flatRepository
     * @return Response
     * @Route("/flat/plan/{number}", name="flat_plan")
     */
    public function flatPlan($number, FlatRepository $flatRepository){
        $flat = $flatRepository->findOneBy(['number' => $number]);
        if(is_null($flat)){
            throw $this->createNotFoundException();
        }
        $result = $this->svgParser->flatPlan($flat);

        $response = new Response($result);
        if($result){
            $disposition = HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                'flat.svg'
            );
            $response->headers->set('Content-Type', 'image/svg+xml');
            $response->headers->set('Content-Disposition', $disposition);
        }

        return $response;
    }

    /**
     * @param $number
     * @param FlatRepository $flatRepository
     * @return Response
     *
     * @Route("/floor/plan/{number}", name="floor_plan")
     */
    public function floorPlan($number, FlatRepository $flatRepository){
        $flat = $flatRepository->findOneBy(['number' => $number]);
        if(is_null($flat)){
            throw $this->createNotFoundException();
        }
        $result = $this->svgParser->floorPlan($flat);

        $response = new Response($result);
        if($result){
            $disposition = HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_INLINE,
                'floor.svg'
            );
            $response->headers->set('Content-Type', 'image/svg+xml');
            $response->headers->set('Content-Disposition', $disposition);
        }

        return $response;
    }
}