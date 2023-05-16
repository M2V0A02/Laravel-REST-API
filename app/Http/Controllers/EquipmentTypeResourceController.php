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
        $equipment = EquipmentType::paginate($per_page);
        return new EquipmentTypeCollection($equipment);
        
    }

}
