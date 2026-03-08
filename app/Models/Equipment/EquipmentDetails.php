<?php

namespace App\Models\Equipment;

use Illuminate\Database\Eloquent\Model;

class EquipmentDetails extends Model
{
    protected $table = 'equipment_details';

    protected $primaryKey = 'pk_equipment_details_id';

    protected $fillable = [
        'equipment_type_id',
        'equipment_brand_model_id',
        'equipment_location_id',
        'equipment_power_source_id',
        'equipment_installer_id',
        'equipment_incharge_id',
        'date_installed',
        'total_amount',
        'created_at',
        'updated_at',
    ];

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id', 'pk_equipment_type_id');
    }

    public function incharge()
    {
        return $this->belongsTo(EquipmentIncharge::class, 'equipment_incharge_id', 'pk_equipment_incharge_id');
    }

    public function installer()
    {
        return $this->belongsTo(EquipmentInstaller::class, 'equipment_installer_id', 'pk_equipment_installer_id');
    }

    /**
     * Location of the equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(EquipmentLocation::class, 'equipment_location_id', 'pk_equipment_location_id');
    }

    public function powersource()
    {
        return $this->belongsTo(EquipmentPowerSource::class, 'equipment_power_source_id', 'pk_equipment_power_source_id');
    }

    public function brand_model()
    {
        return $this->belongsTo(EquipmentBrand::class, 'equipment_brand_model_id', 'pk_equipment_brand_model_id');
    }

    public function cctv_details()
    {
        return $this->hasMany(EquipmentCCTVDetails::class, 'equipment_details_id', 'pk_equipment_details_id');
    }

    public function biometric_details()
    {
        return $this->hasMany(EquipmentBiometricDetails::class, 'equipment_details_id', 'pk_equipment_details_id');
    }
}
