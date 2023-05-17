<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentType;
use App\Http\Resources\EquipmentTypeResource;
use App\Http\Resources\EquipmentTypeCollection;

class EquipmentTypeResourceController extends Controller
{
    
    public function index()
    {
        $per_page = request()->get('per_page', 10);
        if (is_numeric($per_page) && $per_page > 0)
            $per_page = 10;
        $name = request()->get('name', '');
        $query = EquipmentType::query();
        if ($name !== '')
            $query->where('name', 'LIKE', "%$name%");
        $equipment_types = $query->paginate($per_page);
        
        return new EquipmentTypeCollection($equipment_types);    
    }

}
