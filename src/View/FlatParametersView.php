<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatParametersView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatParameters",
 *     type="object"
 * )
 */
class FlatParametersView
{
    /**
     * @OA\Property(
     *     property="rooms",
     *     type="array",
     *     description="Комнатность",
     *     @OA\Items(
     *         type="string",
     *         enum={"s",1,2,3}
     *     )
     * )
     */
    public $rooms = [];

    /**
     * @OA\Property(
     *     property="priceMin",
     *     type="number",
     *     format="integer",
     *     description="Минимально доступная цена",
     *     example=2000000
     * )
     */
    public $priceMin;

    /**
     * @OA\Property(
     *     property="priceMax",
     *     type="number",
     *     format="integer",
     *     description="Максимально доступная цена",
     *     example=10000000
     * )
     */
    public $priceMax;

    /**
     * @OA\Property(
     *     property="areaMin",
     *     type="number",
     *     format="float",
     *     description="Минимально доступная площадь",
     *     example=35.8
     * )
     */
    public $areaMin;

    /**
     * @OA\Property(
     *     property="areaMax",
     *     type="number",
     *     format="float",
     *     description="Максимально доступная площадь",
     *     example=75.4
     * )
     */
    public $areaMax;

    /**
     * @OA\Property(
     *     property="floorMin",
     *     type="number",
     *     format="integer",
     *     description="Минимально доступный этаж",
     *     example=2
     * )
     */
    public $floorMin;

    /**
     * @OA\Property(
     *     property="floorMax",
     *     type="number",
     *     format="integer",
     *     description="Максимально доступный этаж",
     *     example=9
     * )
     */
    public $floorMax;

    /**
     * @OA\Property(
     *     property="statuses",
     *     type="array",
     *     description="Статусы квартир",
     *     @OA\Items(
     *         type="string",
     *         enum={"free","reserved","sold"}
     *     )
     * )
     */
    public $statuses = [];

}