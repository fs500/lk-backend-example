<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class MapView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Map",
 *     type="object"
 * )
 */
class MapView
{

    /**
     * @OA\Property(
     *     property="latitude",
     *     type="number",
     *     format="float"
     * )
     */
    public $latitude;

    /**
     * @OA\Property(
     *     property="longitude",
     *     type="number",
     *     format="float"
     * )
     */
    public $longitude;

    /**
     * @OA\Property(
     *     property="scale",
     *     type="integer",
     * )
     */
    public $scale;
}