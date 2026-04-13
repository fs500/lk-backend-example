<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatCardView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatCard",
 *     type="object"
 * )
 */
class FlatCardView
{
    /**
     * @OA\Property(
     *     property="floors",
     *     type="array",
     *     description="Этажи",
     *     @OA\Items(ref="#/components/schemas/FlatCardFloor")
     * )
     */
    public $floors = [];

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
     *     property="floor",
     *     ref="#/components/schemas/Number"
     * )
     */
    public $floor;

    /**
     * @OA\Property(
     *     property="totalFloors",
     *     ref="#/components/schemas/Number"
     * )
     */
    public $totalFloors;

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
     *     example=45.7,
     *     description="Общая площадь"
     * )
     */
    public $area;

    /**
     * @OA\Property(
     *     property="areaKitchen",
     *     type="number",
     *     format="float",
     *     example=15.7,
     *     description="Площадь кухни"
     * )
     */
    public $areaKitchen;

    /**
     * @OA\Property(
     *     property="areaRooms",
     *     type="number",
     *     format="float",
     *     example=30.0,
     *     description="Площадь кухни"
     * )
     */
    public $areaRooms;

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

    /**
     * @OA\Property(
     *     property="plan3d",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $plan3d;

    /**
     * @OA\Property(
     *     property="planUrl",
     *     ref="#/components/schemas/URI"
     * )
     */
    public $planUrl;

    /**
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     enum={"free","sold","reserved","closed"},
     *     description="Статус квартиры"
     * )
     */
    public $status;

    /**
     * @OA\Property(
     *     property="pdf",
     *     ref="#/components/schemas/URI"
     * )
     */
    public $pdf;
}
