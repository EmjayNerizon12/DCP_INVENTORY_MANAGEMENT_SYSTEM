<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class DCPItemLocation extends Model
{
    use ManagesLookupCrud;

    protected $table = 'dcp_assigned_locations';

    protected $primaryKey = 'pk_dcp_assigned_locations_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function dcpAssignedLocation()
    {
        return $this->hasMany(
            DCPItemAssignedLocation::class,
            'assigned_location_id',               // foreign key on DCPItemAssignedLocation
            'pk_dcp_assigned_locations_id'        // local key on this model
        );
    }
}
