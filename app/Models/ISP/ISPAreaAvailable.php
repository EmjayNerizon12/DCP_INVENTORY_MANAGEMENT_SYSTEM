<?php

namespace App\Models\ISP;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class ISPAreaAvailable extends Model
{
    use ManagesLookupCrud;

    protected $table = 'isp_area_available';

    protected $primaryKey = 'pk_isp_area_available_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function ispAreaDetails()
    {
        return $this->hasMany(ISPAreaDetails::class, 'isp_area_available_id', 'pk_isp_area_available_id');
    }
}
