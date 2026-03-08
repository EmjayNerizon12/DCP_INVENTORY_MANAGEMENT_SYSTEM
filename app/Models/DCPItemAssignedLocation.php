<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPItemAssignedLocation extends Model
{
    protected $table = 'dcp_item_assigned_location';

    protected $primaryKey = 'pk_dcp_item_assigned_location_id ';

    protected $fillable = [
        'dcp_batch_item_id',
        'assigned_location_id',
        'created_at',
        'updated_at',
    ];

    public function dcpAssignedLocation()
    {
        return $this->belongsTo(DCPItemLocation::class, 'assigned_location_id', 'pk_dcp_assigned_locations_id');
    }

    public function dcpBatchItem()
    {
        return $this->belongsTo(DCPBatchItem::class, 'dcp_batch_item_id', 'pk_dcp_batch_items_id');
    }
}
