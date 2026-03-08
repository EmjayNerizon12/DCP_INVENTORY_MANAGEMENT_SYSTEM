<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPItemAssignedUser extends Model
{
    protected $table = 'dcp_item_assigned_user';

    protected $primaryKey = 'pk_dcp_item_assigned_user_id';

    protected $fillable = [
        'dcp_batch_item_id',
        'assignment_type_id',
        'assigned_user_name',
        'date_assigned',
        'date_returned',
        'created_at',
        'updated_at',
    ];

    public function dcpAssignedType()
    {
        return $this->belongsTo(DCPItemAssignedType::class, 'assignment_type_id', 'pk_dcp_assignment_types_id');
    }

    public function dcp_batchItem()
    {
        return $this->hasMany(DCPBatchItem::class, 'dcp_assigned_users', 'pk_dcp_assigned_users_id');
    }
}
