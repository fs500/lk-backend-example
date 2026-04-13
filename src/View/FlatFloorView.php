<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatFloorView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatFloor",
 *     type="object"
 * )
 */
class FlatFloorView
{
    /**
     * @OA\Property(
     *     property="plan",
     *     description="планировка этажа",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $plan;

    /**
     * @OA\Property(
     *     property="floors",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/FlatVisualFloor")
     * )
     */
    public $floors = [];

    /**
     * @OA\Property(
     *     property="flats",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/FlatFloorFlat")
     * )
     */
    public $flats = [];
}