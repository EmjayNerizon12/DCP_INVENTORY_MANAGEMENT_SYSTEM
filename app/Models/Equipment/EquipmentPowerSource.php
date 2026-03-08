<?php

namespace App\Models\Equipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EquipmentPowerSource extends Model
{
    use ManagesLookupCrud;

    protected $table = 'equipment_power_source';

    protected $primaryKey = 'pk_equipment_power_source_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function equipmentDetails()
    {
        return $this->hasMany(EquipmentDetails::class, 'equipment_power_source_id', 'pk_equipment_power_source_id');
    }
}
