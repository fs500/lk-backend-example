<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class FlatVisualView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="FlatVisual",
 *     type="object"
 * )
 */
class FlatVisualView
{

    /**
     * @OA\Property(
     *     property="floors",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/FlatVisualFloor")
     * )
     */
    public $floors = [];
}