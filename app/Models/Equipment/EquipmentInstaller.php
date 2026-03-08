<?php

namespace App\Models\Equipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EquipmentInstaller extends Model
{
    use ManagesLookupCrud;

    protected $table = 'equipment_installer';

    protected $primaryKey = 'pk_equipment_installer_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function equipmentDetails()
    {
        return $this->hasMany(EquipmentDetails::class, 'equipment_installer_id', 'pk_equipment_installer_id');
    }
}
