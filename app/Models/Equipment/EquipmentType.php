<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    protected $table = 'equipment_type';

    protected $primaryKey = 'pk_equipment_type_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function equipmentDetails()
    {
        return $this->hasMany(EquipmentDetails::class, 'equipment_type_id', 'pk_equipment_type_id');
    }
}
