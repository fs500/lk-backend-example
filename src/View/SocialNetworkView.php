<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class SocialNetworkView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="SocialNetwork",
 *     type="object"
 * )
 */
class SocialNetworkView
{

    /**
     * @OA\Property(
     *     property="icon",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $icon;

    /**
     * @OA\Property(
     *     property="url",
     *     ref="#/components/schemas/URI"
     * )
     */
    public $url;
}