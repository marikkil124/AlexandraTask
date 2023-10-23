<?php

use App\Http\Resources\Equipment\EquipmentResource;
use App\Models\Equipment;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/equipment', \App\Http\Controllers\Equipment\EquipmentController::class);
Route::get('/equipments',function (Equipment $eq){
    return EquipmentResource::collection($eq->all());
});
Route::get('/equipment_types', \App\Http\Controllers\EquipmentType\IndexController::class);
