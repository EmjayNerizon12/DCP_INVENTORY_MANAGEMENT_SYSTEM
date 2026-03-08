<?php

namespace App\Models\ISP;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class ISPConnectionType extends Model
{
    use ManagesLookupCrud;

    protected $table = 'isp_connection_type';

    protected $primaryKey = 'pk_isp_connection_type_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function ispDetails()
    {
        return $this->hasMany(ISPDetails::class, 'isp_connection_type_id', 'pk_isp_connection_type_id');
    }
}
