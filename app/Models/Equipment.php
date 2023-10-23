<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $guarded = false;



    public function equipmentType()
    {
        return $this->hasOne(EquipmentType::class, 'id', 'equipment_type');
    }
}
