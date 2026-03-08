<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPItemWarrantyType extends Model
{
    protected $table = 'dcp_warranty_statuses';

    protected $primaryKey = 'pk_dcp_warranty_statuses_id';

    protected $fillable = [
        'name',

        'created_at',
        'updated_at',
    ];

    public function dcpItemWarranties()
    {
        return $this->hasOne(DCPItemWarrantyStatus::class, 'warranty_status_id', 'pk_dcp_warranty_statuses_id');
    }
}
