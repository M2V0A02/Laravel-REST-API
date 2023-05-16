<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentCollection;
use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentResourceController extends Controller
{
    
    public function index()
    {
        return new EquipmentCollection(Equipment::all());
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show(string $id)
    {
        //
    }
    
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
