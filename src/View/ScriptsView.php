<?php


namespace App\View;

/**
 * Class ScriptsView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="Scripts",
 *     type="object"
 * )
 */
class ScriptsView
{

    /**
     * @OA\Property(
     *     property="head",
     *     type="string",
     *     example="<script></script>",
     *     description="Скрипты в секции HEAD"
     * )
     */
    public $head;

    /**
     * @OA\Property(
     *     property="bodyOpen",
     *     type="string",
     *     example="<script></script>",
     *     description="Скрипты после открывающегося тега BODY"
     * )
     */
    public $bodyOpen;

    /**
     * @OA\Property(
     *     property="bodyClose",
     *     type="string",
     *     example="<script></script>",
     *     description="Скрипты перед закрывающимся тегом BODY"
     * )
     */
    public $bodyClose;
}