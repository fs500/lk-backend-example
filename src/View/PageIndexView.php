<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndex",
 *     type="object"
 * )
 */
class PageIndexView
{

    /**
     * @OA\Property(
     *     property="slides",
     *     type="array",
     *     @OA\Items(
     *         ref="#/components/schemas/PageIndexSlideItem"
     *     )
     * )
     */
    public $slides = [];

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(
     *     property="text",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $text;

    /**
     * @OA\Property(
     *     property="leftImage",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $leftImage;

    /**
     * @OA\Property(
     *     property="rightImage",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $rightImage;

    /**
     * @OA\Property(
     *     property="reasonHeaderTop",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $reasonHeaderTop;

    /**
     * @OA\Property(
     *     property="reasonHeaderBottom",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $reasonHeaderBottom;

    /**
     * @OA\Property(
     *     property="reasons",
     *     type="array",
     *     @OA\Items(
     *         ref="#/components/schemas/PageIndexReasonItem"
     *     )
     * )
     */
    public $reasons = [];

    /**
     * @OA\Property(
     *     property="builder",
     *     ref="#/components/schemas/PageIndexBuilder"
     * )
     */
    public $builder;

    /**
     * @OA\Property(
     *     property="infrastructure",
     *     ref="#/components/schemas/PageIndexInfrastructure"
     * )
     */
    public $infrastructure;

    /**
     * @OA\Property(
     *     property="flat",
     *     ref="#/components/schemas/PageIndexFlat"
     * )
     */
    public $flat;

    /**
     * @OA\Property(
     *     property="news",
     *     type="array",
     *     @OA\Items(
     *         ref="#/components/schemas/NewsListItem"
     *     )
     * )
     */
    public $news = [];

}