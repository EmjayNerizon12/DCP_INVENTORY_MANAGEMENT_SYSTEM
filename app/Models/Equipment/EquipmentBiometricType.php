<?php

namespace App\Models\Equipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EquipmentBiometricType extends Model
{
    use ManagesLookupCrud;

    protected $table = 'e_biometric_type';

    protected $primaryKey = 'pk_e_biometric_type_id';

    protected $fillable = [

        'name',
        'created_at',
        'updated_at',
    ];

    public function biometric_details()
    {
        return $this->hasMany(EquipmentBiometricDetails::class, 'e_biometric_type_id', 'pk_e_biometric_type_id');
    }
}
