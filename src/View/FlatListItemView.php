<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatListItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatListItem",
 *     type="object"
 * )
 */
class FlatListItemView
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
     *     property="status",
     *     type="string",
     *     enum={"free","reserved","sold","closed"}
     * )
     */
    public $status;

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
     *     property="floor",
     *     type="number",
     *     format="integer",
     *     example=5
     * )
     */
    public $floor;

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
     *     property="priceFinish",
     *     type="number",
     *     format="integer",
     *     example=5000000
     * )
     */
    public $priceFinish;

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
     *     property="plan",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $plan;
}