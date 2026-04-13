<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexInfrastructureView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexInfrastructure",
 *     type="object"
 * )
 */
class PageIndexInfrastructureView
{
    /**
     * @OA\Property(
     *     property="headerTop",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $headerTop;

    /**
     * @OA\Property(
     *     property="headerBottom",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $headerBottom;

    /**
     * @OA\Property(
     *     property="map",
     *     ref="#/components/schemas/Map"
     * )
     */
    public $map;

    /**
     * @OA\Property(
     *     property="buildingIcon",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $buildingIcon;

    /**
     * @OA\Property(
     *     property="buildingLatitude",
     *     type="number",
     *     format="float"
     * )
     */
    public $buildingLatitude;

    /**
     * @OA\Property(
     *     property="buildingLongitude",
     *     type="number",
     *     format="float"
     * )
     */
    public $buildingLongitude;

    /**
     * @OA\Property(
     *     property="groups",
     *     description="Группы инфраструктуры",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/PageIndexInfrastructureGroupItem")
     * )
     */
    public $groups = [];
}