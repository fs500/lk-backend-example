<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class MortgageCalculator
 * @package App\View
 *
 * @OA\Schema(
 *     schema="MortgageCalculator",
 *     type="object"
 * )
 */
class MortgageCalculatorView
{
    /**
     * @OA\Property(
     *     property="priceMin",
     *     type="integer"
     * )
     */
    public $priceMin;

    /**
     * @OA\Property(
     *     property="priceMax",
     *     type="integer"
     * )
     */
    public $priceMax;

    /**
     * @OA\Property(
     *     property="defaultPrice",
     *     type="integer"
     * )
     */
    public $defaultPrice;

    /**
     * @OA\Property(
     *     property="paymentMin",
     *     type="integer"
     * )
     */
    public $paymentMin;

    /**
     * @OA\Property(
     *     property="paymentMax",
     *     type="integer"
     * )
     */
    public $paymentMax;

    /**
     * @OA\Property(
     *     property="defaultPayment",
     *     type="integer"
     * )
     */
    public $defaultPayment;

    /**
     * @OA\Property(
     *     property="yearsMin",
     *     type="integer"
     * )
     */
    public $yearsMin;

    /**
     * @OA\Property(
     *     property="yearsMax",
     *     type="integer"
     * )
     */
    public $yearsMax;

    /**
     * @OA\Property(
     *     property="defaultYear",
     *     type="integer"
     * )
     */
    public $defaultYear;

    /**
     * @OA\Property(
     *     property="rateMin",
     *     type="integer"
     * )
     */
    public $rateMin;

    /**
     * @OA\Property(
     *     property="rateMax",
     *     type="integer"
     * )
     */
    public $rateMax;

    /**
     * @OA\Property(
     *     property="defaultRate",
     *     type="integer"
     * )
     */
    public $defaultRate;
}