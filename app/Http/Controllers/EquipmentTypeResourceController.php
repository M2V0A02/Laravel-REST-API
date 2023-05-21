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
        $equipmentsType = (new EquipmentTypeService)->index($request);
        return new EquipmentTypeCollection($equipmentsType);      
    }

}
