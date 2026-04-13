<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class DocumentItemView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="DocumentItem",
 *     type="object"
 * )
 */
class DocumentItemView
{

    /**
     * @OA\Property(
     *     property="date",
     *     ref="#/components/schemas/Date"
     * )
     */
    public $date;

    /**
     * @OA\Property(
     *     property="name",
     *     ref="#/components/schemas/Name"
     * )
     */
    public $name;

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header;

    /**
     * @OA\Property(
     *     property="type",
     *     type="string",
     *     description="Тип документа",
     *     example="pdf"
     * )
     */
    public $type;

    /**
     * @OA\Property(
     *     property="size",
     *     type="string",
     *     description="Размер документа",
     *     example="123 Кб"
     * )
     */
    public $size;

    /**
     * @OA\Property(
     *     property="url",
     *     type="string",
     *     format="uri"
     * )
     */
    public $url;
}