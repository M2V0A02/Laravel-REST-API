<?php

namespace App\Http\Requests;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
{
    protected bool $fails = true;

    protected array $messages = [];

    protected Equipment $equipment;

    protected function prepareForValidation()
    {
        $equipment = Equipment::find($this->route('equipment'));

        if (!$equipment) {
            $this->equipment = new Equipment;
            $this->fails = true;
            $this->messages['message'] = 'Этого оборудования не существует';
            return null;
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

    public function fails() 
    {
        return $this->fails;
    }

    public function messages()
    {
        return $this->messages;
    }

    public function equipment()
    {
        return $this->equipment;
    }
}
