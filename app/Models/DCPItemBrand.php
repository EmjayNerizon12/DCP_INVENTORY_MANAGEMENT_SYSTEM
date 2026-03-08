<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class DCPItemBrand extends Model
{
    use ManagesLookupCrud;

    protected $table = 'dcp_item_brands';

    protected $primaryKey = 'pk_dcp_item_brand_id';

    protected $fillable = [
        'name',
        'updated_at',
        'created_at',
    ];
}
