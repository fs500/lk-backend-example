<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatCardFloorView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatCardFloor",
 *     type="object"
 * )
 */
class FlatCardFloorView
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
     *     property="plan",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $plan;

    /**
     * @OA\Property(
     *     property="flats",
     *     type="array",
     *     description="Краткое описание квартир для формирования ссылок на мини плане этажа",
     *     @OA\Items(
     *         @OA\Property(
     *             property="number",
     *             ref="#/components/schemas/Number"
     *         ),
     *         @OA\Property(
     *             property="status",
     *             type="string",
     *             enum={"free","sold","reserved","closed"},
     *             description="Статус квартиры"
     *         )
     *     )
     * )
     */
    public $flats = [];
}