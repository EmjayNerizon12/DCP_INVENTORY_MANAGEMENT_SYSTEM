<?php

namespace App\Models\Equipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EquipmentBrand extends Model
{
    use ManagesLookupCrud;

    protected $table = 'equipment_brand_model';

    protected $primaryKey = 'pk_equipment_brand_model_id';

    protected $fillable = [

        'name',
        'created_at',
        'updated_at',
    ];

    public function equipmentDetails()
    {
        return $this->hasMany(EquipmentDetails::class, 'equipment_brand_model_id', 'pk_equipment_brand_model_id');
    }
}
