<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexBuilderView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexBuilder",
 *     type="object"
 * )
 */
class PageIndexBuilderView
{

    /**
     * @OA\Property(
     *     property="logo",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $logo;

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
     *     property="achievements",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="subHeader",
     *             ref="#/components/schemas/SubHeader"
     *         )
     *     )
     * )
     */
    public $achievements = [];
}