<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class LiveBroadcastView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="LiveBroadcast",
 *     type="object"
 * )
 */
class LiveBroadcastView
{
    /**
     * @OA\Property(
     *     property="type",
     *     type="string",
     *     description="Ссылка на трансляцию",
     *     enum={"m3u", "iframe"}
     * )
     */
    public $type;

    /**
     * @OA\Property(
     *     property="url",
     *     ref="#/components/schemas/URI"
     * )
     */
    public $url;
}