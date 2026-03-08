<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

// item brand
class DCPBatchItemBrand extends Model
{
    use ManagesLookupCrud;

    protected const LOOKUP_NAME_COLUMN = 'brand_name';

    protected $table = 'dcp_batch_item_brands';

    protected $primaryKey = 'pk_dcp_batch_item_brands_id';

    protected $fillable = [
        'brand_name',
        'created_at',
        'updated_at',
    ];

    public function batch_item()
    {
        return $this->hasMany(DCPBatchItem::class, 'brand', 'pk_dcp_batch_item_brands_id');
    }

    public function dcpPackageContent()
    {
        return $this->hasMany(DCPPackageContent::class, 'dcp_batch_item_brands_id', 'pk_dcp_batch_item_brands_id');
    }
}
