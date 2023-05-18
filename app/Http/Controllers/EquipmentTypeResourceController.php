<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Services\EquipmentTypeService;

/**
 * Контроллер для ресурса типа оборудования
 */
class EquipmentTypeResourceController extends Controller
{
    /**
     * Возвращает коллекцию типов оборудования
     *
     * @return EquipmentTypeCollection Коллекция типов оборудования
     */
    public function index()
    {
        $per_page = request()->get('per_page', 10);
        $name = request()->get('name', '') ?? '';
        $equipmentsType = (new EquipmentTypeService)->index($per_page, $name);
        return new EquipmentTypeCollection($equipmentsType);      
    }

}
