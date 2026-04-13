<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexSlideView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexSlideItem",
 *     type="object"
 * )
 */
class PageIndexSlideItemView
{
    /**
     * @OA\Property(
     *     property="image",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $image;

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(
     *     property="description",
     *     ref="#/components/schemas/Description"
     * )
     */
    public $description;

    /**
     * @OA\Property(
     *     property="link",
     *     ref="#/components/schemas/Link"
     * )
     */
    public $link;

    /**
     * @OA\Property(
     *     property="liveBroadcast",
     *     ref="#/components/schemas/Link"
     * )
     */
    public $liveBroadcast;
}