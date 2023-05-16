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
        $name = request()->get('name', '');
        $per_page = request()->get('per_page', 10);
        $query = EquipmentType::query();
        if ($name !== '')
            $query->where('name', 'LIKE', "%$name%");
        $equipment_types = $query->paginate($per_page);
        return new EquipmentTypeCollection($equipment_types);    
    }

}
