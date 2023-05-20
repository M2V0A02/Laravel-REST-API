<?php

namespace App\Http\Requests;

use App\Models\Equipment;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс, представляющий запрос на сохранение оборудования.
 */
class SaveEquipmentRequest extends FormRequest
{
    /**
     * Массив ошибок валидации запроса.
     */
    protected array $errors = [];
    
    /**
     * Массив успешно прошедшего валидацию оборудования.
     */
    protected array $success = [];

    /**
     * Обрабатывает запрос перед валидацией.
     * Производит валидацию данных оборудования и заполняет массивы ошибок и успешно прошедшего валидацию.
     */
    protected function prepareForValidation()
    {
        $equipments = $this->all();
        $validEquipments = [];
        foreach($equipments as $equipmentArray)
        {
            $equipment = new Equipment($equipmentArray);
            $validatorEquipment = \Illuminate\Support\Facades\Validator::make($equipmentArray, [
                'serial_number' => ['required', 'string', 'unique:equipment', new \App\Rules\SerialNumber($equipment->equipmentType)],
                'equipment_type_id' => 'required|integer|exists:equipment_types,id',
                'desc' => 'string'
            ]);
            if ($validatorEquipment->fails()) {
                $this->errors[] =  [
                    'equipment' => $equipment,
                    'error_message' => $validatorEquipment->errors()
                ];
            } else {
                $validEquipments[] = $equipment;
            }
        }
        $this->success = $validEquipments;
    }

    /**
     * Получить проверенные данные из запроса.
     *
     * @param  string|null  $key указывает на ключ из массива проверенных данных
     * @param  mixed  $default определяет значение, которое вернется, если указанный ключ не найден в массиве проверенных данных.
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        if ($key !== null) {
            return $this->success[$key] ?? $default;
        } else {
            return $this->success;
        }
    }

    /**
     * Получить все сообщения об ошибках валидации и неправельные объекты.
     *
     * @param  string|null  $key указывает на ключ из массива проверенных данных
     * @param  mixed  $default определяет значение, которое вернется, если указанный ключ не найден в массиве проверенных данных.
     *
     * @return array
     */
    public function errors($key = null, $default = null)
    {
        if ($key !== null) {
            return $this->errors[$key] ?? $default;
        } else {
            return $this->errors;
        }
    }
}
