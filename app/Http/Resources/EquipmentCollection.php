<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * EquipmentCollection - коллекция ресурсов для модели Equipment
 */
class EquipmentCollection extends ResourceCollection
{

    protected array $errorEquipments = [];

    public function __construct($resource, $errorEquipments = [])
    {
        parent::__construct($resource);
        $this->errorEquipments = $errorEquipments;
    }


     /**
     * Преобразовать коллекцию ресурсов в массив.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<int|string, mixed>  Массив преобразованных ресурсов
     */
    public function toArray(Request $request): array
    {
        $result = [];
        if (count($this->errorEquipments))
            $result['errors'] = $this->errorEquipments;
        $result['success'] =  parent::toArray($request);
        return $result;
    }
}
