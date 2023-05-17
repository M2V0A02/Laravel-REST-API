<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\Rule;

class SerialNumber implements Rule
{
    protected $equipmentType;

    public function __construct(EquipmentType $equipmentType)
    {
        $this->equipmentType = $equipmentType;
    }

    public function passes($attribute, $value)
    {
        return !preg_replace('/' . $this->equipmentType->getRegexFromMask() . '/', '', $value);
    }

    public function message()
    {
        return 'Серийный номер не соответствует маски';
    }
}
