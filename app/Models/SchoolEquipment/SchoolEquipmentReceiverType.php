<?php

namespace App\Models\SchoolEquipment;

use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentReceiverType extends Model
{
    protected $table = 'school_equipment_receiver_types';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function schoolEquipmentAccountabilities()
    {
        return $this->hasMany(SchoolEquipmentAccountabilty::class, 'receiver_type_id', 'id');
    }
}
