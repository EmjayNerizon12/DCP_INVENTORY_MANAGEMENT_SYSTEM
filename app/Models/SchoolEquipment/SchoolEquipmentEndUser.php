<?php

namespace App\Models\SchoolEquipment;

use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentEndUser extends Model
{
    protected $table = 'school_equipment_end_users';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'suffix',
        'accountability_id',
        'date_assigned',
        'created_at',
        'updated_at',
    ];

    public function schoolEquipmentAccountabilities()
    {
        return $this->belongsTo(SchoolEquipmentAccountabilty::class, 'accountability_id', 'id');
    }
}
