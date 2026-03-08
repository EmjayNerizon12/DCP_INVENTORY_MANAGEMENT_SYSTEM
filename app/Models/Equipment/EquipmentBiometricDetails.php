<?php

namespace App\Models\Equipment;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;

class EquipmentBiometricDetails extends Model
{
    protected $table = 'e_biometric_details';

    protected $primaryKey = 'pk_e_biometric_details_id';

    protected $fillable = [
        'equipment_details_id',
        'school_id',
        'e_biometric_type_id',
        'no_of_units',
        'no_of_functional',
        'created_at',
        'updated_at',
    ];

    public function biometric_type()
    {
        return $this->belongsTo(EquipmentBiometricType::class, 'e_biometric_type_id', 'pk_e_biometric_type_id');
    }

    public function equipment_details()
    {
        return $this->belongsTo(EquipmentDetails::class, 'equipment_details_id', 'pk_equipment_details_id');
    }

    public function schools()
    {
        return $this->belongsTo(School::class, 'school_id', 'pk_school_id');
    }
}
