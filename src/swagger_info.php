<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="Brown House API",
 *   version="0.1.0",
 *   @OA\Contact(
 *     email="m@art.su"
 *   )
 * )
 *
 *
 *
 * ######################### Примитивы #########################
 * @OA\Schema(
 *     schema="Id",
 *     type="integer",
 *     description="ID объекта",
 *     example=12
 * )
 *
 * @OA\Schema(
 *     schema="Header",
 *     type="string",
 *     description="Заголовок",
 *     example="Мой заголовок!"
 * )
 *
 * @OA\Schema(
 *     schema="Name",
 *     type="string",
 *     description="Какое то имя или название",
 *     example="Браун Хаус"
 * )
 *
 * @OA\Schema(
 *     schema="SubHeader",
 *     type="string",
 *     description="Подзаголовок",
 *     example="Мой подзаголовок!"
 * )
 *
 * @OA\Schema(
 *     schema="Description",
 *     type="string",
 *     description="Описание",
 *     example="Какое-то краткое описание.."
 * )
 *
 * @OA\Schema(
 *     schema="Text",
 *     type="string",
 *     description="Текст",
 *     example="Какой-то длинный текст, или даже HTML.."
 * )
 *
 * @OA\Schema(
 *     schema="Path",
 *     type="string",
 *     description="Путь",
 *     example="my_object_path"
 * )
 *
 * @OA\Schema(
 *     schema="Price",
 *     type="number",
 *     description="Цена",
 *     example="1200000"
 * )
 *
 * @OA\Schema(
 *     schema="URI",
 *     type="string",
 *     format="uri",
 *     description="URI",
 *     example="https://vk.com"
 * )
 *
 * @OA\Schema(
 *     schema="Phone",
 *     type="string",
 *     description="Телефон",
 *     example="+7 (812) 123-45-67"
 * )
 *
 * @OA\Schema(
 *     schema="Date",
 *     type="string",
 *     description="Дата",
 *     format="date",
 *     example="2021-02-23"
 * )
 *
 * @OA\Schema(
 *     schema="DateTime",
 *     type="string",
 *     description="Дата и время",
 *     format="date-time",
 *     example="2021-07-21T17:32:28Z"
 * )
 *
 * @OA\Schema(
 *     schema="Image",
 *     type="string",
 *     description="Изображение",
 *     format="uri",
 *     example="https://somesite.info/some_image.jpg"
 * )
 *
 * @OA\Schema(
 *     schema="File",
 *     type="string",
 *     description="Файл",
 *     format="uri",
 *     example="https://somesite.info/some_file.pdf"
 * )
 *
 * @OA\Schema(
 *     schema="Email",
 *     type="string",
 *     format="email",
 *     description="Email",
 *     example="example@example.com"
 * )
 *
 * @OA\Schema(
 *     schema="Success",
 *     type="object",
 *     @OA\Property(
 *         property="success",
 *         type="boolean",
 *         example=true
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Number",
 *     type="number",
 *     format="integer",
 *     description="Какой-то номер",
 *     example=1
 * )
 *
 * @OA\Schema(
 *     schema="Rooms",
 *     enum={"s","1","2","3"}
 * )
 *
 * @OA\Schema(
 *     schema="Statuses",
 *     enum={"free","sold","reserved"}
 * )
 *
 * ######################### Ошибки #########################
 * @OA\Schema(
 *     schema="ErrorNotFound",
 *     type="object",
 *     description="Не найдено",
 *     @OA\Property(
 *       property="status",
 *       type="integer",
 *       example=404
 *     ),
 *     @OA\Property(
 *       property="message",
 *       type="string",
 *       example="Объект не найден"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ErrorCritical",
 *     type="object",
 *     description="Непредвиденная ошибка",
 *     @OA\Property(
 *       property="status",
 *       type="integer",
 *       example=500
 *     ),
 *     @OA\Property(
 *       property="message",
 *       type="string",
 *       example="Непредвиденная ошибка"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ErrorBadRequest",
 *     type="object",
 *     description="Плохой запрос",
 *     @OA\Property(
 *       property="status",
 *       type="integer",
 *       example=400
 *     ),
 *     @OA\Property(
 *       property="message",
 *       type="string",
 *       example="Некорректный запрос"
 *     )
 * )
 *
 * ######################### Параметры #########################
 *
 * @OA\Parameter(
 *     parameter="id",
 *     name="id",
 *     description="ID объекта",
 *     example=21,
 *     @OA\Schema(
 *       type="integer",
 *       format="int64",
 *     ),
 *     in="path",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="path",
 *     name="path",
 *     description="Путь объекта",
 *     example="my_true_object_path",
 *     @OA\Schema(
 *       type="string"
 *     ),
 *     in="path",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="number",
 *     name="number",
 *     description="Номер объекта",
 *     example="1",
 *     @OA\Schema(
 *       type="string"
 *     ),
 *     in="path",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="flatNumber",
 *     name="number",
 *     description="Номер квартиры",
 *     example=25,
 *     @OA\Schema(
 *       type="numeric"
 *     ),
 *     in="path",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="floorNumber",
 *     name="number",
 *     description="Номер этажа",
 *     example=3,
 *     @OA\Schema(
 *       type="numeric"
 *     ),
 *     in="path",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="token",
 *     name="token",
 *     description="Токен пользователя",
 *     @OA\Schema(
 *       type="string",
 *     ),
 *     in="query",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="id_query",
 *     name="id",
 *     description="ID объекта",
 *     example=21,
 *     @OA\Schema(
 *       type="integer",
 *       format="int64",
 *     ),
 *     in="query",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="email",
 *     name="email",
 *     description="Email пользователя",
 *     @OA\Schema(
 *       type="string",
 *       format="email"
 *     ),
 *     in="query",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="phone",
 *     name="phone",
 *     description="Телефон пользователя",
 *     @OA\Schema(
 *       type="string"
 *     ),
 *     example="+71234567890",
 *     in="query",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="rooms",
 *     name="rooms",
 *     description="Комнатность",
 *     @OA\Schema(
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Rooms")
 *     ),
 *     example="['s', 1]",
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="priceMin",
 *     name="priceMin",
 *     description="Цена от",
 *     @OA\Schema(
 *       type="numeric",
 *       format="integer"
 *     ),
 *     example=1000000,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="priceMax",
 *     name="priceMax",
 *     description="Цена до",
 *     @OA\Schema(
 *       type="numeric",
 *       format="integer"
 *     ),
 *     example=1200000,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="areaMin",
 *     name="areaMin",
 *     description="Площадь от",
 *     @OA\Schema(
 *       type="numeric",
 *       format="float"
 *     ),
 *     example=35.6,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="areaMax",
 *     name="areaMax",
 *     description="Площадь до",
 *     @OA\Schema(
 *       type="numeric",
 *       format="float"
 *     ),
 *     example=56.8,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="floorMin",
 *     name="floorMin",
 *     description="Этаж от",
 *     @OA\Schema(
 *       type="numeric",
 *       format="integer"
 *     ),
 *     example=4,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="floorMax",
 *     name="floorMax",
 *     description="Этаж до",
 *     @OA\Schema(
 *       type="numeric",
 *       format="integer"
 *     ),
 *     example=8,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="sortField",
 *     name="sortField",
 *     description="Поле сортировки",
 *     @OA\Schema(
 *       type="string",
 *       enum={"rooms","area","floor","price"}
 *     ),
 *     example="price",
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="sortOrder",
 *     name="sortOrder",
 *     description="Порядок сортировки",
 *     @OA\Schema(
 *       type="string",
 *       enum={"asc","desc"}
 *     ),
 *     example="asc",
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="statuses",
 *     name="statuses",
 *     description="Статусы квартир",
 *     @OA\Schema(
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Statuses")
 *     ),
 *     example="['free', 'reserved']",
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="limit",
 *     name="limit",
 *     description="Количество записей",
 *     @OA\Schema(
 *       type="number",
 *       format="integer"
 *     ),
 *     example=15,
 *     in="query",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="offset",
 *     name="offset",
 *     description="Запись от которой выбираются следующие",
 *     @OA\Schema(
 *       type="number",
 *       format="integer"
 *     ),
 *     example=10,
 *     in="query",
 *     required=true
 * )
 *
 * @OA\Parameter(
 *     parameter="before",
 *     name="before",
 *     description="Количество предыдущих записей",
 *     @OA\Schema(
 *       type="number",
 *       format="integer"
 *     ),
 *     example=10,
 *     in="query",
 *     required=false
 * )
 *
 * @OA\Parameter(
 *     parameter="after",
 *     name="after",
 *     description="Количество следующих записей",
 *     @OA\Schema(
 *       type="number",
 *       format="integer"
 *     ),
 *     example=10,
 *     in="query",
 *     required=false
 * )
 *
 * ######################### Заголовки #########################
 */
