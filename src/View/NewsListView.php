<?php


namespace App\View;

/**
 * Class NewsListView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="NewsList",
 *     type="object"
 * )
 */
class NewsListView
{
    /**
     * @OA\Property(
     *     property="before",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/NewsListItem")
     * )
     */
    public $before = [];

    /**
     * @OA\Property(
     *     property="after",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/NewsListItem")
     * )
     */
    public $after = [];
}