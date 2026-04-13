<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class NewsSingleView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="NewsSingle",
 *     type="object"
 * )
 */
class NewsSingleView
{
    /**
     * @OA\Property(
     *     property="id",
     *     ref="#/components/schemas/Id"
     * )
     */
    public $id;

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(
     *     property="date",
     *     ref="#/components/schemas/Date"
     * )
     */
    public $date;

    /**
     * @OA\Property(
     *     property="path",
     *     ref="#/components/schemas/Path"
     * )
     */
    public $path;

    /**
     * @OA\Property(
     *     property="description",
     *     ref="#/components/schemas/Description"
     * )
     */
    public $description;

    /**
     * @OA\Property(
     *     property="text",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $text;

    /**
     * @OA\Property(property="image", ref="#/components/schemas/Image")
     */
    public $image;

    /**
     * @OA\Property(
     *     property="list",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/NewsListItem")
     * )
     */
    public $list = [];

}