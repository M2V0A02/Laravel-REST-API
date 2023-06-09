<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Класс EquipmentTypeCollection - коллекция ресурсов типов оборудования
 */
class EquipmentTypeCollection extends ResourceCollection
{
    /**
     * Преобразовать коллекцию ресурсов в массив.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<int|string, mixed>  Массив преобразованных ресурсов
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
