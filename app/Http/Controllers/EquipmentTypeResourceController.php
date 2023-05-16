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
        return new EquipmentTypeCollection(EquipmentType::all());
    }

}
