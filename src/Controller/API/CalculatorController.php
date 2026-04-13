<?php


namespace App\Controller\API;


use App\Entity\Calculator;
use App\Entity\Flat;
use App\Repository\CalculatorRepository;
use App\Repository\FlatRepository;
use App\View\MortgageCalculatorView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CalculatorController
 * @package App\Controller\API
 *
 * @Route("/api/calculator",name="api_calculator_")
 */
class CalculatorController extends AbstractController
{
    /**
     * @OA\Get(
     *     tags={"Калькулятор"},
     *     path="/api/calculator/{flatNumber}",
     *     summary="Ипотечный калькулятор квартиры",
     *     @OA\Parameter(ref="#/components/parameters/flatNumber"),
     *     @OA\Response(
     *       response=200,
     *       description="Данные страницы ипотечного калькулятора квартиры",
     *       @OA\JsonContent(ref="#/components/schemas/MortgageCalculator")
     *     )
     * )
     *
     * @Route("/{flatNumber}", "index")
     * @param $flatNumber
     * @param FlatRepository $repository
     * @param CalculatorRepository $calculatorRepository
     * @return JsonResponse
     */
    public function index($flatNumber, FlatRepository $repository, CalculatorRepository $calculatorRepository){
        $flat = $repository->findOneBy(['number' => $flatNumber]);
        if(is_null($flat)){
            throw $this->createNotFoundException();
        }
        $calculator = $calculatorRepository->findOneBy([]);
        $prices = $repository->getMinMaxPrice();
        if(is_null($calculator)){
            $calculator = new Calculator();
        }

        $view = $this->populateCalculatorView($calculator, $flat, $prices);

        return new JsonResponse($view);
    }

    protected function populateCalculatorView(Calculator $calculator, Flat $flat, $prices){
        $view = new MortgageCalculatorView();
        $view->priceMin = (int)$prices['min'];
        $view->priceMax = (int)$prices['max'];
        $view->defaultPrice = $flat->getPrice();
        $view->paymentMin = $flat->getPrice()/100*$calculator->getPaymentMin();
        $view->paymentMax = $flat->getPrice()/100*$calculator->getPaymentMax();
        $view->defaultPayment = $flat->getPrice()/100*$calculator->getDefaultPayment();
        $view->yearsMin = $calculator->getYearsMin();
        $view->yearsMax = $calculator->getYearsMax();
        $view->defaultYear = $calculator->getDefaultYears();
        $view->rateMin = $calculator->getRateMin();
        $view->rateMax = $calculator->getRateMax();
        $view->defaultRate = $calculator->getRateDefault();

        return $view;
    }
}