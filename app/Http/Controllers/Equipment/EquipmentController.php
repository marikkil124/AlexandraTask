<?php

namespace App\Http\Controllers\Equipment;


use App\Http\Requests\Equipment\StoreRequest;
use App\Http\Requests\Equipment\UpdateRequest;
use App\Http\Resources\Equipment\EquipmentResource;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipment = Equipment::paginate(10);

        return EquipmentResource::collection($equipment);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
          return  $this->service->store($request);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        return  $this->service->update($request,$id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Equipment::whereid($id)->delete();
    }
}
