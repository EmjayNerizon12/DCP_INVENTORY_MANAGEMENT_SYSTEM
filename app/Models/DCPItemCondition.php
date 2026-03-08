<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPItemCondition extends Model
{
    protected $table = 'dcp_item_condition';

    protected $primaryKey = 'pk_dcp_item_condition_id';

    protected $fillable = [
        'dcp_batch_item_id',
        'current_condition_id',
        'created_at',
        'updated_at',
    ];

    public function dcpBatchItem()
    {
        return $this->belongsTo(DCPBatchItem::class, 'dcp_batch_item_id', 'pk_dcp_batch_items_id');
    }

    public function dcpCurrentCondition()
    {
        return $this->belongsTo(DCPCurrentCondition::class, 'current_condition_id', 'pk_dcp_current_conditions_id');
    }
}
