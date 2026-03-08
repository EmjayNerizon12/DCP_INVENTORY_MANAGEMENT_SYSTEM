<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPItemTypes extends Model
{
    protected $table = 'dcp_item_types';

    protected $primaryKey = 'pk_dcp_item_types_id';

    protected $fillable = [

        'code',
        'name',
        'created_at',
        'updated_at',
    ];

    public function dcpBatchItems()
    {
        return $this->hasMany(DCPBatchItem::class, 'item_type_id', 'pk_dcp_item_types_id');
    }

    public function dcpPackageContents()
    {
        return $this->hasMany(DCPPackageContent::class, 'dcp_item_types_id', 'pk_dcp_item_types_id');
    }
}
