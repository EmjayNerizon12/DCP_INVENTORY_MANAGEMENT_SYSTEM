<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPItemWarrantyStatus extends Model
{
    protected $table = 'dcp_item_warranty'; // Specify table name if different

    protected $primaryKey = 'pk_dcp_item_warranty_id';

    protected $fillable = [
        'dcp_batch_item_id',
        'warranty_start_date',
        'warranty_end_date',
        'warranty_contract',
        'warranty_remaining',
        'warranty_status_id',
    ];

    // Optional: Define relationships
    public function batchItem()
    {
        return $this->belongsTo(DCPBatchItem::class, 'dcp_batch_item_id');
    }

    public function status()
    {
        return $this->belongsTo(DCPItemWarrantyType::class, 'warranty_status_id', 'pk_dcp_warranty_statuses_id');
    }
}
