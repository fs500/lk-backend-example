<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class MenuView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Menu",
 *     type="object"
 * )
 */
class MenuView
{
    /**
     * @OA\Property(
     *     property="items",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/MenuItem")
     * )
     */
    public $items = [];

    /**
     * @OA\Property(
     *     property="socialNetwork",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/SocialNetwork")
     * )
     */
    public $socialNetwork = [];
}