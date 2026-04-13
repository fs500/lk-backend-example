<?php


namespace App\View;

/**
 * Class HowToGetItemView
 * @package App\View
 * @OA\Schema(
 *     schema="HowToGetItem",
 *     type="object"
 * )
 */
class HowToGetItemView
{
    /**
     * @OA\Property(
     *     property="icon",
     *     ref="#/components/schemas/Image"
     * )
     */
    public $icon = "";

    /**
     * @OA\Property(
     *     property="header",
     *     ref="#/components/schemas/Header"
     * )
     */
    public $header = "";

    /**
     * @OA\Property(
     *     property="text",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $text = "";

    /**
     * @OA\Property(
     *     property="note",
     *     ref="#/components/schemas/Text"
     * )
     */
    public $note;
}