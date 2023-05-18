<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\Rule;

/**
 * Правило валидации для серийного номера оборудования
 */
class SerialNumber implements Rule
{
     /**
     * Тип оборудования, для которого будет использоваться это правило валидации
     *
     * @var EquipmentType $equipmentType Тип оборудования
     */
    protected $equipmentType;
    protected string $message = '';
    /**
     * Определяет из какого типа оборудования нужно будет брать маску.
     *
     * @param EquipmentType $equipmentType тип оборудование из которого будут брать маску
     */
    public function __construct(?EquipmentType $equipmentType)
    {
        $this->equipmentType = $equipmentType;
    }

    /**
     * Определяет, соответствует ли серийный номер маски типа оборудования
     *
     * @param string $attribute Название атрибута
     * @param mixed $value Значение атрибута
     * @return bool Результат проверки: true, если значение прошло проверку, иначе - false
     */
    public function passes($attribute, $value)
    {
        if ($this->equipmentType === null) {
            $this->message = 'Для этого оборудования неопределен его тип';
            return false;
        }

        if (preg_replace($this->equipmentType->getRegexFromMask(), '', $value)) {
            $this->message = 'Серийный номер  не соответствует маски';
            return false;
        }

        return true;
    }
    
    /**
     * Получает сообщение об ошибке валидации
     *
     * @return string Сообщение об ошибке
     */
    public function message()
    {
        return $this->message;
    }
}
