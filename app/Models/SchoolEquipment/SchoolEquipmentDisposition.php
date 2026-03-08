<?php

namespace App\Models\SchoolEquipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentDisposition extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_equipment_dispositions';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function equipmentStatuses()
    {
        return $this->hasMany(SchoolEquipmentStatus::class, 'disposition_status_id', 'id');
    }
}
