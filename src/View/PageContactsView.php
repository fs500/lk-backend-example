<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class ContactsView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageContacts",
 *     type="object"
 * )
 */
class PageContactsView
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
     *     property="subHeader",
     *     ref="#/components/schemas/SubHeader"
     * )
     */
    public $subHeader;

    /**
     * @OA\Property(
     *     property="office",
     *     ref="#/components/schemas/ContactsItem"
     * )
     */
    public $office;

    /**
     * @OA\Property(
     *     property="object",
     *     ref="#/components/schemas/ContactsItem"
     * )
     */
    public $object;

    /**
     * @OA\Property(
     *     property="map",
     *     ref="#/components/schemas/Map"
     * )
     */
    public $map;

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
     *     property="socialNetwork",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/SocialNetwork")
     * )
     */
    public $socialNetworks = [];
}