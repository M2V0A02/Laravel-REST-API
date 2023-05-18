<?php
namespace App\Http\Services;

use App\Models\EquipmentType;

class EquipmentTypeService
{
    public function index(int $per_page = 10, string $name = '') 
    {
        if (is_numeric($per_page) && $per_page <= 0)
            $per_page = 10;
        $query = EquipmentType::query();
        if ($name !== '')
            $query->where('name', 'LIKE', "%$name%");
        
        return $query->paginate($per_page);
    }
}