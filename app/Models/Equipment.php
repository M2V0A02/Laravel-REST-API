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
    
    public function save(array $options = [])
    {
        $validator = Validator::make($this->attributes, [
            'serial_number' => new SerialNumber($this->equipmentType),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        parent::save($options);
        return true;
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
    
    // protected static function boot()
    // {
    //     parent::boot();
    //     Validator::extend('serial_number', function($attribute, $value, $parameters, $validator) {
    //         dd($validator);
    //         $equipment = $validator->getData()[$parameters[0]];
    //         $regx = $equipment->equipmentType->getRegexFromMask;
    //         if ($regx === '') return true;
    //         return preg_match($regx, $value);
    //     });
    // }
    protected $fillable = [
        'equipment_type_id',
        'serial_number',
        'desc'
    ];
    
    
}
