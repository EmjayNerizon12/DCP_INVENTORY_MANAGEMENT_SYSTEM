<?php

namespace App\Models\SchoolEquipment;

use Illuminate\Database\Eloquent\Model;

class EquipmentItems extends Model
{
    protected $table = 'school_equipment_items';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function schoolEquipments()
    {
        return $this->hasMany(SchoolEquipment::class, 'equipment_item_id', 'id');
    }
}
