<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPBatchApproval extends Model
{
    protected $table = 'dcp_batch_approval';

    protected $primaryKey = 'dcp_batch_approval_id';

    protected $fillable = [
        'dcp_batches_id',
        'status',
        'submitted_at',
        'updated_at',
        'created_at',
    ];

    public function dcpBatch()
    {
        return $this->belongsTo(DCPBatch::class, 'dcp_batches_id', 'pk_dcp_batches_id');
    }
}
