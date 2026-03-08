<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPPackageContent extends Model
{
    protected $table = 'dcp_package_content';

    protected $primaryKey = 'pk_dcp_package_content_id';

    protected $fillable = [
        'dcp_package_types_id',
        'dcp_item_types_id',
        'dcp_batch_item_brands_id',
        'unit_price',
        'quantity',
        'created_at',
        'updated_at',
    ];

    public function dcpPackageType()
    {
        return $this->belongsTo(DCPPackageTypes::class, 'dcp_package_types_id', 'pk_dcp_package_types_id');
    }

    public function dcpItemType()
    {
        return $this->belongsTo(DCPItemTypes::class, 'dcp_item_types_id', 'pk_dcp_item_types_id');
    }

    public function dcpBatchItemBrand()
    {
        return $this->belongsTo(DCPBatchItemBrand::class, 'dcp_batch_item_brands_id', 'pk_dcp_batch_item_brands_id');
    }
}
