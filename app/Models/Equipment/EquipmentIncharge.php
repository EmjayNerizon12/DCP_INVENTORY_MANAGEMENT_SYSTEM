<?php

namespace App\Models\Equipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EquipmentIncharge extends Model
{
    use ManagesLookupCrud;

    protected $table = 'equipment_incharge';

    protected $primaryKey = 'pk_equipment_incharge_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function equipmentDetails()
    {
        return $this->hasMany(EquipmentDetails::class, 'equipment_incharge_id', 'pk_equipment_incharge_id');
    }
}
