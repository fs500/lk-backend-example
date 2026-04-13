<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageCommerceRoomsItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageCommerceRoomsItem",
 *     type="object"
 * )
 */
class PageCommerceRoomsItemView
{
    /**
     * @OA\Property(
     *     property="image",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $image;

    /**
     * @OA\Property(
     *     property="price",
     *     ref="#/components/schemas/Price"
     * )
     */
    public $price;

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
     *     property="floors",
     *     type="number",
     *     format="integer",
     *     description="Этажность здания",
     *     example=9
     * )
     */
    public $floors;

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