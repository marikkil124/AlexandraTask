<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipment\StoreRequest;
use App\Http\Resources\Equipment\EquipmentResource;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Service\EquipmentService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }


}
