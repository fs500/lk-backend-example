<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class NewsListView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="NewsListItem",
 *     type="object"
 * )
 */
class NewsListItemView
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
}