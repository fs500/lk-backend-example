<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatFloorFlatView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatFloorFlat",
 *     type="object"
 * )
 */
class FlatFloorFlatView
{

    /**
     * @OA\Property(
     *     property="id",
     *     ref="#/components/schemas/Id"
     * )
     */
    public $id;

    /**
     * @OA\Property(
     *     property="number",
     *     ref="#/components/schemas/Number"
     * )
     */
    public $number;

    /**
     * @OA\Property(
     *     property="rooms",
     *     type="string",
     *     enum={"s","1","2","3"}
     * )
     */
    public $rooms;

    /**
     * @OA\Property(
     *     property="area",
     *     type="number",
     *     format="float",
     *     example=45.7
     * )
     */
    public $area;

    /**
     * @OA\Property(
     *     property="price",
     *     type="number",
     *     format="integer",
     *     example=5000000
     * )
     */
    public $price;

    /**
     * @OA\Property(
     *     property="priceAction",
     *     type="number",
     *     format="integer",
     *     example=5000000
     * )
     */
    public $priceAction;

    /**
     * @OA\Property(
     *     property="priceActionText",
     *     type="string",
     *     example="Текст акции"
     * )
     */
    public $priceActionText;

    /**
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     enum={"free","sold","reserved","closed"}
     * )
     */
    public $status;
}