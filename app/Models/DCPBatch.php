<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPBatch extends Model
{
    // DcpBatch.php
    protected $table = 'dcp_batches';

    protected $primaryKey = 'pk_dcp_batches_id';

    protected $fillable = [
        'dcp_package_type_id',
        'school_id',
        'batch_label',
        'description',
        'email',
        'budget_year',
        'delivery_date',
        'supplier_name',
        'mode_of_delivery',
        'submission_status',
    ];

    public function dcpBatchItems()
    {
        return $this->hasMany(DCPBatchItem::class, 'dcp_batch_id', 'pk_dcp_batches_id');
    }

    public function dcpPackageType()
    {
        return $this->belongsTo(DCPPackageTypes::class, 'dcp_package_type_id', 'pk_dcp_package_types_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'pk_school_id');
    }

    public function approval()
    {
        return $this->hasOne(DCPBatchApproval::class, 'dcp_batches_id', 'pk_dcp_batches_id');
    }
}
