<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class LinkView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Link",
 *     type="object",
 *     description="Ссылка на внешний\внутренний ресурс"
 * )
 */
class LinkView
{

    const TYPE_URL = "url";
    const TYPE_PAGE = "page";
    const TYPE_FILE = "file";
    const TYPE_FLATS_VISUAL = "flats_visual";
    const TYPE_FLATS_PARAMETER = "flats_parameter";
    const TYPE_LIVE_BROADCAST = "livebroadcast";
    const TYPE_NEWS = "news";

    /**
     * @var array
     * @OA\Property(
     *     property="data",
     *     type="object",
     *     @OA\Property(
     *         property="type",
     *         type="string",
     *         description="Тип страницы",
     *         enum={"url", "file", "page", "flats_visual", "flats_parameter", "livebroadcast", "news"},
     *         example="url"
     *     ),
     *     @OA\Property(
     *         property="path",
     *         description="Компоненты url",
     *         type="array",
     *         @OA\Items(type="string", example="index")
     *     )
     * )
     */
    public $data;

    /**
     * @var boolean
     * @OA\Property(
     *     property="popup",
     *     type="boolean",
     *     description="всплывающее окно"
     * )
     */
    public $popup = false;

    /**
     * @var string
     * @OA\Property(property="text", ref="#/components/schemas/Text")
     */
    public $text;

}