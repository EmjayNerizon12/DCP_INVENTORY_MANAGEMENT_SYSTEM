<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCPPackageTypes extends Model
{
    protected $table = 'dcp_package_types';

    protected $primaryKey = 'pk_dcp_package_types_id';

    protected $fillable = [
        'code',
        'name',
        'created_at',
        'updated_at',
    ];

    public function dcpBatches()
    {
        return $this->hasMany(DCPBatch::class, 'dcp_package_type_id', 'pk_dcp_package_types_id');
    }

    public function dcpPackageContents()
    {
        return $this->hasMany(DCPPackageContent::class, 'dcp_package_types_id', 'pk_dcp_package_types_id');
    }
}
