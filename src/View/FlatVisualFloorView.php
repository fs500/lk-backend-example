<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatVisualFloorView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatVisualFloor",
 *     type="object"
 * )
 */
class FlatVisualFloorView
{

    /**
     * @OA\Property(
     *     property="number",
     *     ref="#/components/schemas/Number"
     * )
     */
    public $number;

    /**
     * @OA\Property(
     *     property="inSales",
     *     type="number",
     *     format="integer",
     *     description="Количество квартир в продаже",
     *     example=2
     * )
     */
    public $inSales;

    /**
     * @OA\Property(
     *     property="flats",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/FlatVisualFloorFlat")
     * )
     */
    public $flats = [];
}