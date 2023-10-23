<?php

namespace App\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\Equipment\EquipmentResource;
use App\Models\Equipment;
use App\Models\Product;
use http\Env\Request;


class EquipmentService
{
    public function store($request)
   {
       $validated = $request->validated();
       //return response($data);
       return new EquipmentResource(Equipment::create($validated));
    }
    public function update($request,$id)
    {
        $validated = $request->validated();
        Equipment::where('id',$id)->update($validated);
        $data = Equipment::where('id',$id)->first();
        return new EquipmentResource($data);


    }

}
