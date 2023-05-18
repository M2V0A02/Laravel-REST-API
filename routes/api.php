<?php

use App\Http\Controllers\EquipmentResourceController;
use App\Http\Controllers\EquipmentTypeResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('equipment', EquipmentResourceController::class)->except([
    'create', 'edit'
]);
Route::resource('equipment-type', EquipmentTypeResourceController::class)->only([
    'index'
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
