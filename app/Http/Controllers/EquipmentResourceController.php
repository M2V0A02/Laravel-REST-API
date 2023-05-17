<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentResourceController extends Controller
{
    
    public function index()
    {
        $per_page = request()->get('per_page', 10);
        if (is_numeric($per_page) && $per_page <= 0)
            $per_page = 10;
        $serial_number = request()->get('serial_number', '');
        $desc = request()->get('desc', '');
        $query = Equipment::query();
        if ($serial_number !== '') 
            $query->where('serial_number', 'LIKE', "%$serial_number%");
        if ($desc !== '')
            $query->where('desc', 'LIKE', "%$desc%");
        $equipments = $query->paginate($per_page);
        return new EquipmentCollection($equipments);    
    }

    public function store(Request $request)
    {
        $jsonStringArray = $request->getContent();
        $equipmentJsonArray = json_decode($jsonStringArray, true);
        $returnEquipments = [];
        $errorEquipments = [];
        foreach($equipmentJsonArray as $equipmentJson) {
            $equipment = new Equipment($equipmentJson);
            try {
                $equipment->save();
            } catch(ValidationException $e) {
                $errorEquipments[] = [
                    'equipment' => $equipment,
                    'error_message' => $e->getMessage()
                ];
                continue;
            }
            $returnEquipments[] = $equipment;
        }
        return response()->json([
            'success' => new EquipmentCollection($returnEquipments),
            'errors' => $errorEquipments
        ]);
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
        try {
        $equipment->update($payload);
        } catch(\Exception $e) {
            return response()->json([
                'error_message' => $e->getMessage()
            ], 422);
        }
        return new EquipmentResource($equipment);
    }

    
    public function destroy(string $id)
    {
        Equipment::destroy($id);
    }
}
