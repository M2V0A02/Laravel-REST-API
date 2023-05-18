<?php

namespace App\Http\Resources;

use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * EquipmentResource - ресурсный класс для модели Equipment
 *
 * @property-read int    $id     Идентификатор оборудования
 * @property-read string $serial_number Серийный номер оборудования
 * @property-read string $desc   Описание оборудования
 * @property-read string $created_at Дата и время создания объекта
 * @property-read string $updated_at Дата и время последнего обновления объекта
 * @property-read EquipmentType $equipmentType Тип оборудования
 */

class EquipmentResource extends JsonResource
{
    /**
     * Преобразовать ресурс в массив.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $equipment_type = $this->equipmentType;
        return [
            "id" => $this->id,
            "equipment_type" => [
                "id" => $equipment_type->id,
                "name" => $equipment_type->name,
                "mask" => $equipment_type->mask,
            ],
            "serial_number" => $this->serial_number,
            "desc" => $this->desc,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
