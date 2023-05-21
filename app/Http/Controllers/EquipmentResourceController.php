<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
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
        $q = $request->get('q', '') ?? '';
        $equipments = (new EquipmentService)->index($per_page, $serial_number, $desc, $q);
        return new EquipmentCollection($equipments);    
    }
    /**
     * Создать новый объект оборудования.
     *
     * @param SaveEquipmentRequest $request HTTP-запрос, содержащий данные оборудования для сохранения.
     *
     * @return EquipmentCollection Возвращает экземпляр класса EquipmentCollection, содержащий результат операции.
     */
    public function store(SaveEquipmentRequest $request): EquipmentCollection
    {
        $result = (new EquipmentService)->saveEquipment($request);
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
     * @param UpdateEquipmentRequest $request    запрос на обновление оборудования.
     * @param string $id            Идентификатор оборудования
     *
     * @return EquipmentResource        EquipmentResource ответ
     */
    public function update(UpdateEquipmentRequest $request, string $id): EquipmentResource
    {
        $message = (new EquipmentService)->updateEquipment($request);
        return (new EquipmentResource($request->equipment()))->additional($message);
    }

    /**
     * Удаляет запись об оборудовании.
     *
     * Этот метод удаляет запись об оборудовании с указанным ID.
     *
     * @param string $id ID записи об оборудовании, которую нужно удалить.
     * @return \Illuminate\Http\JsonResponse JSON-ответ, сообщающий об успешном удалении или об ошибке.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = Equipment::destroy($id);
        return $deleted ? response()->json(['message' => 'Удаление произошло успешно'], 200)
                        : response()->json(['message' => 'Ресурс не найден'], 404);
    }
}
