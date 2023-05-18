<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для типа оборудования
 */
class EquipmentType extends Model
{
    use HasFactory;

    /**
     * Филлер для массового заполнения полей модели
     *
     * @var array $fillable Массив полей модели для массового заполнения
     */
    protected $fillable = [
        'name',
        'mask'
    ];

    /**
     * Получает все оборудование данного типа оборудования
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Связь с оборудованием
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
    
    /**
     * Получает регулярное выражение из маски типа оборудования
     *
     * @return string Регулярное выражение, построенное из маски
     */
    public function getRegexFromMask()
    {
        $mask = $this->mask;
        $count = mb_strlen($mask);
        $regx = '';
        for ($i = 0; $i < $count; $i++) {
            switch ($mask[$i]) {
                case "N":
                    $regx .= '[0-9]';
                    break;
                case "A":
                    $regx .= '[A-Z]';
                    break;
                case "a":
                    $regx .= '[a-z]';
                    break;
                case "X":
                    $regx .= '[A-Z0-9]';
                    break;
                case "Z":
                    $regx .= '[-_@]';
                    break;
                default:
                    break;
            }
        };        
        return $regx;
    }
}
