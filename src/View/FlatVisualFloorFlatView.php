<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatVisualFloorFlatView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatVisualFloorFlat",
 *     type="object"
 * )
 */
class FlatVisualFloorFlatView
{

    /**
     * @OA\Property(
     *     property="type",
     *     type="string",
     *     enum={"s",1,2,3},
     *     example="s",
     *     description="Тип квартиры по комнатности"
     * )
     */
    public $type;

    /**
     * @OA\Property(
     *     property="quantity",
     *     type="number",
     *     format="integer",
     *     description="Количество квартир указанного типа на этаже",
     *     example=2
     * )
     */
    public $quantity;

    /**
     * @OA\Property(
     *     property="minPrice",
     *     type="number",
     *     format="integer",
     *     description="Минимальная цена квартиры указанного типа на этаже"
     * )
     */
    public $minPrice;
}