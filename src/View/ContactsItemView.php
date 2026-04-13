<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class ContactsOfficeView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="ContactsItem",
 *     type="object"
 * )
 */
class ContactsItemView
{

    /**
     * @OA\Property(
     *     property="address",
     *     type="string"
     * )
     */
    public $address;

    /**
     * @OA\Property(
     *     property="route",
     *     ref="#/components/schemas/Link"
     * )
     */
    public $route;

    /**
     * @OA\Property(
     *     property="images",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Image")
     * )
     */
    public $mapIcon;

    /**
     * @OA\Property(
     *     property="mapLatitude",
     *     type="number",
     *     format="float"
     * )
     */
    public $mapLatitude;

    /**
     * @OA\Property(
     *     property="mapLongitude",
     *     type="number",
     *     format="float"
     * )
     */
    public $mapLongitude;
}