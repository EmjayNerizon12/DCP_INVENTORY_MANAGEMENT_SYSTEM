<?php

namespace App\Models\SchoolEquipment;

use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentStatus extends Model
{
    protected $table = 'school_equipment_statuses';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'school_equipment_id',
        'start_warranty_date',
        'end_warranty_date',
        'equipment_condition_id',
        'disposition_status_id',
        'equipment_location',
        'non_functional',
        'created_at',
        'updated_at',
    ];

    public function equipmentCondition()
    {
        return $this->belongsTo(SchoolEquipmentCondition::class, 'equipment_condition_id', 'id');
    }

    public function schoolEquipment()
    {
        return $this->belongsTo(SchoolEquipment::class, 'school_equipment_id', 'id');
    }

    public function dispositionStatus()
    {
        return $this->belongsTo(SchoolEquipmentDisposition::class, 'disposition_status_id', 'id');
    }
}
