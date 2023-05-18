<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Модель для оборудования
 */
class Equipment extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * Получает тип оборудования, к которому принадлежит данное оборудование
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Связь с типом оборудования
     */
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
    
    /**
     * Филлер для массового заполнения полей модели
     *
     * @var array $fillable Массив полей модели для массового заполнения
     */
    protected $fillable = [
        'serial_number',
        'desc',
        'equipment_type_id'
    ];
    
    
}
