<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class DCPItemModeDelivery extends Model
{
    use ManagesLookupCrud;

    protected $table = 'dcp_item_mode_delivery';

    protected $primaryKey = 'pk_dcp_item_mode_delivery_id';

    protected $fillable = [
        'name',
        'updated_at',
        'created_at',
    ];
}
