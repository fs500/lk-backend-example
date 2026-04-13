<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class MenuItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="MenuItem",
 *     type="object"
 * )
 */
class MenuItemView
{
    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(property="link", ref="#/components/schemas/Link")
     */
    public $link;

}