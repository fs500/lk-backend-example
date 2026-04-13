<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexFlatView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexFlat",
 *     type="object"
 * )
 */
class PageIndexFlatView
{

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(
     *     property="link",
     *     ref="#/components/schemas/Link"
     * )
     */
    public $link;

    /**
     * @OA\Property(
     *     property="items",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/PageIndexFlatItem")
     * )
     */
    public $items = [];
}