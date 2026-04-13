<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class MetatagView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Metatag",
 *     type="object",
 *     description="Метатеги"
 * )
 */
class MetatagView
{
    /**
     * @OA\Property(
     *   property="title",
     *   type="string",
     *   nullable=true,
     *   example="Контакты",
     * )
     */
    public $title;

    /**
     * @OA\Property(
     *   property="keywords",
     *   type="string",
     *   nullable=true,
     *   example="адрес телефон email",
     * )
     */
    public $keywords;

    /**
     * @OA\Property(
     *   property="description",
     *   type="string",
     *   nullable=true,
     *   example="Адрес и телефон компании",
     * )
     */
    public $description;
}