<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageBuildingProgressView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageBuildingProgress",
 *     type="object"
 * )
 */
class PageBuildingProgressView
{

    /**
     * @OA\Property(
     *     property="liveBroadcast",
     *     ref="#/components/schemas/LiveBroadcast"
     * )
     */
    public $liveBroadcast;

    /**
     * @OA\Property(
     *     property="years",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/PageBuildingProgressYear")
     * )
     */
    public $years = [];
}