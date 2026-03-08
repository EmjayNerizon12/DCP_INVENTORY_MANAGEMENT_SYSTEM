<?php

namespace App\Models\Equipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EquipmentCCTVType extends Model
{
    use ManagesLookupCrud;

    protected $table = 'e_cctv_camera_type';

    protected $primaryKey = 'pk_e_cctv_camera_type_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function cctvDetails()
    {
        return $this->hasMany(EquipmentCCTVDetails::class, 'e_cctv_camera_type_id', 'pk_e_cctv_camera_type_id');
    }
}
