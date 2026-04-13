<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageIndexInfrastructureGroupItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageIndexInfrastructureGroupItem",
 *     type="object"
 * )
 */
class PageIndexInfrastructureGroupItemView
{
    /**
     * @OA\Property(
     *     property="id",
     *     ref="#/components/schemas/Id"
     * )
     */
    public $id;

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(
     *     property="icon",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $icon;

    /**
     * @OA\Property(
     *     property="items",
     *     description="Объект инфраструктуры",
     *     type="array",
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
     *             property="address",
     *             ref="#/components/schemas/Text"
     *         ),
     *         @OA\Property(
     *             property="latitude",
     *             type="number",
     *             format="float"
     *         ),
     *         @OA\Property(
     *             property="longitude",
     *             type="number",
     *             format="float"
     *         )
     *     )
     * )
     */
    public $items = [];
}