<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexReasonItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexReasonItem",
 *     type="object"
 * )
 */
class PageIndexReasonItemView
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
     *     property="text",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $text;

    /**
     * @OA\Property(
     *     property="image",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $image;
}