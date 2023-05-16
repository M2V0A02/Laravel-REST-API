<?php

use App\Http\Controllers\EquipmentResouceController;
use App\Http\Controllers\EquipmentTypeControllerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('equipment', EquipmentResouceController::class)->except([
    'create', 'edit'
]);
Route::resource('equipment-types', EquipmentTypeControllerController::class)->only([
    'index'
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
