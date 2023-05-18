<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Services\EquipmentService;

class EquipmentResourceController extends Controller
{
    
    public function index()
    {
        $per_page = request()->get('per_page', 10);
        $serial_number = request()->get('serial_number', '') ?? '';
        $desc = request()->get('desc', '') ?? '';
        $equipments = (new EquipmentService)->index($per_page, $serial_number, $desc);
        return new EquipmentCollection($equipments);    
    }

    public function store(Request $request)
    {
        $equipmentJsonArray = json_decode($request->getContent(), true);
        $result = (new EquipmentService)->saveEquipment($equipmentJsonArray);
        
        return response()->json($result, 201);
    }

    
    public function show(string $id)
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }
    
    public function update(Request $request, string $id)
    {
        $equipment = Equipment::find($id);
        $payload = request()->only([
            'serial_number',
            'desc'
        ]);
        $result = (new EquipmentService)->updateEquipment($equipment, $payload);
        return response()->json($result);
    }

    
    public function destroy(string $id)
    {
        Equipment::destroy($id);
    }
}
