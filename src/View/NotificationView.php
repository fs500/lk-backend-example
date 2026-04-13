<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class NotificationView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Notification",
 *     type="object"
 * )
 */
class NotificationView
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
     *     property="text",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $text = "";

    /**
     * @OA\Property(
     *     property="image",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $image = "";

    /**
     * @OA\Property(
     *     property="buttonText",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $buttonText;

    /**
     * @OA\Property(
     *     property="buttonUrl",
     *     ref="#/components/schemas/URI"
     * )
     */
    public $buttonUrl;
}