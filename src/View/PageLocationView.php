<?php


namespace App\View;

/**
 * Class PageLocationView
 * @package App\View
 * @OA\Schema(
 *     schema="PageLocation",
 *     type="object"
 * )
 */
class PageLocationView
{

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header = "";

    /**
     * @var array
     * @OA\Property(
     *     property="howToGet",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/HowToGetItem")
     * )
     */
    public $howToGet = [];

    /**
     * @OA\Property(
     *     property="infrastructure",
     *     ref="#/components/schemas/PageIndexInfrastructure"
     * )
     */
    public $infrastructure;


}