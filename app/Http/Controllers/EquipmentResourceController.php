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
     * @return EquipmentCollection        JSON ответ
     */
    public function store(Request $request): EquipmentCollection
    {
        $equipmentJsonArray = json_decode($request->getContent(), true);
        $result = (new EquipmentService)->saveEquipment($equipmentJsonArray);
        return new EquipmentCollection($result['success'], $result['errors']);
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
     * @return EquipmentResource        EquipmentResource ответ
     */
    public function update(Request $request, string $id): EquipmentResource
    {
        $equipment = Equipment::find($id);
        $payload = request()->only([
            'desc',
            'serial_number',
            'equipment_type_id'
        ]);
        $message = (new EquipmentService)->updateEquipment($equipment, $payload);
        return (new EquipmentResource($equipment))->additional($message);
    }

    /**
     * Удаляет запись об оборудовании.
     *
     * Этот метод удаляет запись об оборудовании с указанным ID.
     *
     * @param string $id ID записи об оборудовании, которую нужно удалить.
     * @return \Illuminate\Http\JsonResponse JSON-ответ, сообщающий об успешном удалении или об ошибке.
     */
    public function destroy(string $id):JsonResponse
    {
        $deleted = Equipment::destroy($id);
        return $deleted ? response()->json(['message' => 'Удаление произошло успешно'], 200)
                        : response()->json(['message' => 'Ресурс не найден'], 404);
    }
}
