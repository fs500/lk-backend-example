<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexFlatItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexFlatItem",
 *     type="object"
 * )
 */
class PageIndexFlatItemView
{

    /**
     * @OA\Property(
     *     property="plan",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $plan;

    /**
     * @OA\Property(
     *     property="price",
     *     ref="#/components/schemas/Price"
     * )
     */
    public $price;

    /**
     * @OA\Property(
     *     property="priceAction",
     *     ref="#/components/schemas/Price"
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
     *     property="floor",
     *     type="number",
     *     format="integer",
     *     description="Этаж квартиры",
     *     example=3
     * )
     */
    public $floor;

    /**
     * @OA\Property(
     *     property="totalFloors",
     *     type="number",
     *     format="integer",
     *     description="Этажность здания",
     *     example=9
     * )
     */
    public $totalFloors;

    /**
     * @OA\Property(
     *     property="rooms",
     *     type="string",
     *     description="Комнатность квартиры",
     *     example="3 комн."
     * )
     */
    public $rooms;

    /**
     * @OA\Property(
     *     property="area",
     *     type="number",
     *     format="float",
     *     description="Площадь квартиры",
     *     example=56.36
     * )
     */
    public $area;

    /**
     * @OA\Property(
     *     property="number",
     *     type="number",
     *     format="integer",
     *     description="Номер квартиры",
     *     example=32
     * )
     */
    public $number;
}