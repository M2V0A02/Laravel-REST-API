<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * EquipmentTypeResource - ресурсный класс для модели типа оборудования
 *
 * @property-read int    $id     Идентификатор типа оборудования
 * @property-read string $name   Название оборудования
 * @property-read string $mask   Маска оборудования
 * @property-read string $created_at Дата и время создания объекта
 * @property-read string $updated_at Дата и время последнего обновления объекта
 */
class EquipmentTypeResource extends JsonResource
{
    /**
     * Преобразовать ресурс в массив.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mask' => $this->mask,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
