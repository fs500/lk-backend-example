<?php


namespace App\View;

/**
 * Class PageBuildingProgressItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageBuildingProgressYear",
 *     type="object"
 * )
 */
class PageBuildingProgressYearView
{
    /**
     * @OA\Property(
     *     property="number",
     *     ref="#/components/schemas/Number",
     * )
     */
    public $year;

    /**
     * @OA\Property(
     *     property="months",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/PageBuildingProgressMonth")
     * )
     */
    public $months = [];
}