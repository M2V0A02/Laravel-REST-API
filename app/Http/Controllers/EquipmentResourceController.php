<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentResource;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentResourceController extends Controller
{
    
    public function index()
    {
        $per_page = request()->get('per_page', 10);
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
        $equipment = new Equipment($request->all());
        $equipment->save();
        return new EquipmentResource($equipment);
    }

    
    public function show(string $id)
    {
        return new EquipmentResource(Equipment::findOrFail($id));
    }
    
    public function update(Request $request, string $id)
    {
        $equipment = Equipment::find($id);
        $equipment->fill($request->all());
        $equipment->save();
    }

    
    public function destroy(string $id)
    {
        Equipment::destroy($id);
    }
}
