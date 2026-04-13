<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatListView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatList",
 *     type="object"
 * )
 */
class FlatListView
{
    /**
     * @OA\Property(
     *     property="sortField",
     *     type="string",
     *     enum={"rooms","area","floor","price"},
     *     description="Поле сортировки текущего списка",
     *     example="price"
     * )
     */
    public $sortField;

    /**
     * @OA\Property(
     *     property="sortOrder",
     *     type="string",
     *     enum={"asc","desc"},
     *     description="Порядок сортировки текущего списка",
     *     example="asc"
     * )
     */
    public $sortOrder;

    /**
     * @OA\Property(
     *     property="flats",
     *     type="array",
     *     description="Список квартир",
     *     @OA\Items(ref="#/components/schemas/FlatListItem")
     * )
     */
    public $flats = [];

    /**
     * @OA\Property(
     *     property="totalFloors",
     *     type="number",
     *     format="integer",
     *     description="Максимально доступный этаж",
     *     example=9
     * )
     */
    public $totalFloors;
}