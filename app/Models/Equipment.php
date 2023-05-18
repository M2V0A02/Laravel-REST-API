<?php

namespace App\Models;

use App\Rules\SerialNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;

use Validator;
class Equipment extends Model
{
    use HasFactory, SoftDeletes;
    
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
    
    protected $fillable = [
        'serial_number',
        'desc',
        'equipment_type_id'
    ];
    
    
}
