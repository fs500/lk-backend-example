<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageHowToBuyView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageHowToBuy",
 *     type="object"
 * )
 */
class PageHowToBuyView
{

    /**
     * @OA\Property(
     *     property="headerTopLine",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $headerTopLine;

    /**
     * @OA\Property(
     *     property="headerBottomLine",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $headerBottomLine;

    /**
     * @OA\Property(
     *     property="image",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $image;

    /**
     * @OA\Property(
     *     property="terms",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="description",
     *             ref="#/components/schemas/Description"
     *         ),
     *         @OA\Property(
     *             property="icon",
     *             ref="#/components/schemas/Image"
     *         )
     *     )
     *
     * )
     */
    public $terms;

    /**
     * @OA\Property(
     *     property="howToHeader",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $howToHeader;

    /**
     * @OA\Property(
     *     property="howToSubheader",
     *     ref="#/components/schemas/SubHeader"
     * )
     */
    public $howToSubheader;

    /**
     * @OA\Property(
     *     property="howToTerms",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="description",
     *             ref="#/components/schemas/Description"
     *         ),
     *         @OA\Property(
     *             property="icon",
     *             ref="#/components/schemas/Image"
     *         )
     *     )
     *
     * )
     */
    public $howToTerms;

    /**
     * @OA\Property(
     *     property="promos",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="description",
     *             ref="#/components/schemas/Description"
     *         ),
     *         @OA\Property(
     *             property="deadline",
     *             ref="#/components/schemas/Date"
     *         ),
     *         @OA\Property(
     *             property="text",
     *             ref="#/components/schemas/Text"
     *         )
     *     )
     *
     * )
     */
    public $promos;

    /**
     * @OA\Property(
     *     property="reservationImage",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $reservationImage;

    /**
     * @OA\Property(
     *     property="reservationHeader",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $reservationHeader;

    /**
     * @OA\Property(
     *     property="reservationTerms",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="description",
     *             ref="#/components/schemas/Description"
     *         ),
     *         @OA\Property(
     *             property="icon",
     *             ref="#/components/schemas/Image"
     *         )
     *     )
     * )
     */
    public $reservationTerms;

    /**
     * @OA\Property(
     *     property="calculator",
     *     ref="#/components/schemas/MortgageCalculator"
     * )
     */
    public $calculator;

    /**
     * @OA\Property(
     *     property="bankHeader",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $bankHeader;

    /**
     * @OA\Property(
     *     property="banks",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="image",
     *             ref="#/components/schemas/Image"
     *         )
     *     )
     * )
     */
    public $banks;
}