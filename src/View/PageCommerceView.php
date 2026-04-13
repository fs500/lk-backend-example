<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageCommerceView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageCommerce",
 *     type="object"
 * )
 */
class PageCommerceView
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
     *     property="leftHeader",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $leftHeader;

    /**
     * @OA\Property(
     *     property="leftImage",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $leftImage;

    /**
     * @OA\Property(
     *     property="rightHeader",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $rightHeader;

    /**
     * @OA\Property(
     *     property="rightImage",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $rightImage;

    /**
     * @OA\Property(
     *     property="promoHeader",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $promoHeader;

    /**
     * @OA\Property(
     *     property="promoText",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $promoText;

    /**
     * @OA\Property(
     *     property="promoItems",
     *     type="array",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="description",
     *             ref="#/components/schemas/Description"
     *         )
     *     )
     * )
     */
    public $promoItems = [];

    /**
     * @OA\Property(
     *     property="proprties",
     *     type="array",
     *     description="Характеристики помещений",
     *     @OA\Items(
     *         @OA\Property(
     *             property="header",
     *             ref="#/components/schemas/Header"
     *         ),
     *         @OA\Property(
     *             property="description",
     *             ref="#/components/schemas/Description"
     *         ),
     *         @OA\Property(
     *             property="icon",
     *             ref="#/components/schemas/Image"
     *         )
     *     )
     * )
     */
    public $properties = [];

    /**
     * @OA\Property(
     *     property="rooms",
     *     type="array",
     *     description="Помещения проекта",
     *     @OA\Items(ref="#/components/schemas/PageCommerceRoomsItem")
     * )
     */
    public $rooms = [];
}