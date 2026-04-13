<?php


namespace App\View;

use OpenApi\Annotations as OA;

/**
 * Class PageDocumentsView
 * @package App\View
 *
 * @OA\Schema(
 *     schema="PageDocuments",
 *     type="object"
 * )
 */
class PageDocumentsView
{

    /**
     * @OA\Property(
     *     property="documents",
     *     description="Список документов",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/DocumentItem")
     * )
     */
    public $documents = [];
}