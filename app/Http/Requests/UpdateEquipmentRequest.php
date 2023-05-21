<?php

namespace App\Http\Requests;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс формы запроса для обновления объекта Equipment.
 *
 * @package App\Http\Requests
 */
class UpdateEquipmentRequest extends FormRequest
{
    /**
     * Флаг, указывающий на прохождение валидации.
     *
     * @var bool
     */
    protected bool $fails = true;
    
    /**
     * Сообщения.
     *
     * @var array
     */
    protected array $messages = [];

    /**
     * Объект, содержащий обновленные данные.
     *
     * @var Equipment
     */
    protected Equipment $equipment;
    
    /**
     * Валидации данных.
     * 
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $equipment = Equipment::find($this->route('equipment'));

        if (!$equipment) {
            $this->equipment = new Equipment;
            $this->fails = true;
            $this->messages['message'] = 'Этого оборудования не существует';
            return;
        }
        
        $payload = request()->only([
            'desc',
            'serial_number',
            'equipment_type_id'
        ]);
        
        $equipmentType = isset($payload['equipment_type_id'])
          ? EquipmentType::find($payload['equipment_type_id'])
          : $equipment->equipmentType;
        
        $validator = \Illuminate\Support\Facades\Validator::make($payload, [
            'serial_number' => ['string', 'unique:equipment', new \App\Rules\SerialNumber($equipmentType)],
            'equipment_type_id' => 'integer|exists:equipment_types,id',
            'desc' => 'string'
        ]);

        $this->equipment = $equipment->fill($payload);

        if ($validator->fails()) 
        {
            $this->fails = true;
            $this->messages = [
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ];
        } else {
            $this->messages['message'] = 'Оборудование обновлено';
            $this->fails = false;
        }
        
    }
    /**
     * Возвращает флаг прохождения валидации.
     *
     * @return bool
     */
    public function fails(): bool 
    {
        return $this->fails;
    }
    
    /**
     * Возвращает сообщения.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * Возвращает объект Equipment с обновленными данными.
     *
     * @return Equipment
     */
    public function equipment(): Equipment
    {
        return $this->equipment;
    }
}
