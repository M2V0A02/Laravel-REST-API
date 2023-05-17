<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mask'
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

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
