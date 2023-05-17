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

    public function update(array $attributes = [], array $options = [])
    {
        $validator = Validator::make($options, [
            'serial_number' => new SerialNumber($this->equipmentType),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        parent::update($attributes, $options);
        return true;
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }
    
    protected $fillable = [
        'serial_number',
        'desc'
    ];
    
    
}
