<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class CommonView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Common",
 *     type="object"
 * )
 */
class CommonView
{

    /**
     * @OA\Property(
     *     property="phone",
     *     ref="#/components/schemas/Phone"
     * )
     */
    public $phone;

    /**
     * @OA\Property(
     *     property="email",
     *     ref="#/components/schemas/Email"
     * )
     */
    public $email;

    /**
     * @OA\Property(
     *     property="socialNetworks",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/SocialNetwork")
     * )
     */
    public $socialNetworks = [];

    /**
     * @OA\Property(
     *     property="scripts",
     *     ref="#/components/schemas/Scripts"
     * )
     */
    public $scripts;

    /**
     * @OA\Property(
     *     property="legalText",
     *     type="string",
     *     description="Правовая информация в футере сайта"
     * )
     */
    public $legalText;

    /**
     * @OA\Property(
     *     property="notification",
     *     ref="#/components/schemas/Notification",
     *     nullable=true
     * )
     */
    public $notification;
}