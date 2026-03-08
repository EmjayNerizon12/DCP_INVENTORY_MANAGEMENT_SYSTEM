<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;

class EquipmentCCTVDetails extends Model
{
    protected $table = 'e_cctv_details';

    protected $primaryKey = 'pk_e_cctv_details_id';

    protected $fillable = [
        'equipment_details_id',
        'e_cctv_camera_type_id',
        'no_of_units',
        'school_id',
        'no_of_functional',
        'created_at',
        'updated_at',
    ];

    public function equipment_details()
    {
        return $this->belongsTo(EquipmentDetails::class, 'equipment_details_id', 'pk_equipment_details_id');
    }

    public function cctv_type()
    {
        return $this->belongsTo(EquipmentCCTVType::class, 'e_cctv_camera_type_id', 'pk_e_cctv_camera_type_id');
    }
}
