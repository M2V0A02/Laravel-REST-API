<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentTypeCollection;
use App\Http\Services\EquipmentTypeService;
use Illuminate\Http\Request;

/**
 * Контроллер для ресурса типа оборудования
 */
class EquipmentTypeResourceController extends Controller
{
    /**
     * Возвращает коллекцию типов оборудования
     *
     * @param Request $request Объект запроса
     * 
     * @return EquipmentTypeCollection Коллекция типов оборудования
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page', 10);
        $name = $request->get('name', '') ?? '';
        $q = $request->get('q', '') ?? '';
        $equipmentsType = (new EquipmentTypeService)->index($per_page, $name, $q);
        return new EquipmentTypeCollection($equipmentsType);      
    }

}
