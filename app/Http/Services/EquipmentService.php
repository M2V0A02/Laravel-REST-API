<?php
namespace App\Http\Services;

use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Rules\SerialNumber;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Validator;

/**
 * Сервис оборудования
 */
class EquipmentService
{
    /**
     * Получить список оборудования с пагинацией и поиском
     *
     * @param int    $per_page      Число элементов на странице
     * @param string $serial_number Серийный номер оборудования
     * @param string $desc          Описание оборудования
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Список оборудования с пагинацией
     */
    public function index(int $per_page = 10, string $serial_number = '', string $desc = '') 
    {
        if (is_numeric($per_page) && $per_page <= 0)
            $per_page = 10;
        $query = Equipment::query();
        if ($serial_number !== '') 
            $query->where('serial_number', 'LIKE', "%$serial_number%");
        if ($desc !== '')
            $query->where('desc', 'LIKE', "%$desc%");
        
        return $query->paginate($per_page);
    }

    /**
     * Сохранить оборудование
     *
     * @param array $equipmentJsonArray Массив данных об оборудовании в формате JSON
     *
     * @return array Результат сохранения оборудования
     */
    public function saveEquipment(array $equipmentJsonArray) 
    {
        $returnEquipments = [];
        $errorEquipments = [];
        foreach($equipmentJsonArray as $equipmentJson) {
            $equipment = new Equipment($equipmentJson);
            $validator = Validator::make($equipmentJson, [
                'serial_number' => new SerialNumber($equipment->equipmentType),
            ]);
    
            if ($validator->fails()) {
                $errorEquipments[] = [
                    'equipment' => $equipment,
                    'error_message' => $validator->errors()
                ];
                continue;
            }

            $equipment->save(); 
            $returnEquipments[] = $equipment;
        }
        return [
            'success' => $returnEquipments,
            'errors' => $errorEquipments
        ];
    }

     /**
     * Обновить оборудование
     *
     * @param \App\Models\Equipment $equipment Объект оборудования для обновления
     * @param array                 $payload   Данные об оборудовании
     *
     * @return \App\Http\Resources\EquipmentResource|array Обновленный объект оборудования или сообщение об ошибке
     */
    public function updateEquipment($equipment, $payload) {
        $validator = Validator::make($payload, [
            'serial_number' => new SerialNumber($equipment->equipmentType),
        ]);

        if ($validator->fails()) {
            return ['error_message' => $validator->errors()];
        }

        $equipment->update($payload);
        return new EquipmentResource($equipment);
    }
}