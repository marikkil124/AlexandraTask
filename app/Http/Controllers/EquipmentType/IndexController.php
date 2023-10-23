<?php

namespace App\Http\Controllers\EquipmentType;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentType\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke()
    {
        $eqTypes = EquipmentType::all();

       return  EquipmentTypeResource::collection($eqTypes);
    }
}
