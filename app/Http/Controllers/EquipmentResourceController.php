<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Services\EquipmentService;

/**
 * EquipmentResourceController - контроллер для управления ресурсом оборудования
 */
class EquipmentResourceController extends Controller
{
    /**
     * Получить список оборудования.
     *
     * @param Request $request Объект запроса
     *
     * @return EquipmentCollection  Коллекция ресурсов оборудования
     */
    public function index(Request $request): EquipmentCollection
    {
        $per_page = $request->get('per_page', 10);
        $serial_number = $request->get('serial_number', '') ?? '';
        $desc = $request->get('desc', '') ?? '';
        $equipments = (new EquipmentService)->index($per_page, $serial_number, $desc);
        return new EquipmentCollection($equipments);    
    }
    /**
     * Создать новый объект оборудования.
     *
     * @param Request $request      Объект запроса
     *
     * @return JsonResponse        JSON ответ
     */
    public function store(Request $request): JsonResponse
    {
        $equipmentJsonArray = json_decode($request->getContent(), true);
        $result = (new EquipmentService)->saveEquipment($equipmentJsonArray);
        
        return response()->json($result, 201);
    }

    /**
     * Получить объект оборудования по ID.
     *
     * @param string $id           Идентификатор оборудования
     *
     * @return EquipmentResource   Ресурс объекта оборудования
     */
    public function show(string $id): EquipmentResource
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }

    /**
     * Обновить объект оборудования.
     *
     * @param Request $request      Объект запроса
     * @param string $id            Идентификатор оборудования
     *
     * @return JsonResponse        JSON ответ
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $equipment = Equipment::find($id);
        $payload = request()->only([
            'serial_number',
            'desc'
        ]);
        $result = (new EquipmentService)->updateEquipment($equipment, $payload);
        return response()->json($result);
    }

    /**
     * Удаляет запись об оборудовании.
     *
     * Этот метод удаляет запись об оборудовании с указанным ID.
     *
     * @param string $id ID записи об оборудовании, которую нужно удалить.
     * @return void
     */
    public function destroy(string $id)
    {
        Equipment::destroy($id);
    }
}
