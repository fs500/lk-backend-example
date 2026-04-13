<?php


namespace App\View;


/**
 * Class PageBuildingProgressMonthView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageBuildingProgressMonth",
 *     type="object"
 * )
 */
class PageBuildingProgressMonthView
{
    /**
     * @OA\Property(
     *     property="month",
     *     ref="#/components/schemas/Number",
     * )
     */
    public $month;

    /**
     * @OA\Property(
     *     property="description",
     *     ref="#/components/schemas/Description"
     * )
     */
    public $description;

    /**
     * @OA\Property(
     *     property="images",
     *     type="array",
     *     @OA\Items(
     *         ref="#/components/schemas/Image"
     *     )
     * )
     */
    public $images = [];
}