<?php

namespace App\Models\SchoolEquipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentModeOfAcquisition extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_equipment_mode_of_acquisitions';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function schoolEquipments()
    {
        return $this->hasMany(SchoolEquipment::class, 'mode_of_acquisition_id', 'id');
    }
}
