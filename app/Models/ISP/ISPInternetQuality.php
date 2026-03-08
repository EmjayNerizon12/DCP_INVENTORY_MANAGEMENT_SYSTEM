<?php

namespace App\Models\ISP;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class ISPInternetQuality extends Model
{
    use ManagesLookupCrud;

    protected $table = 'isp_internet_quality';

    protected $primaryKey = 'pk_isp_internet_quality_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function ispDetails()
    {
        return $this->hasMany(ISPDetails::class, 'isp_internet_quality_id', 'pk_isp_internet_quality_id');
    }
}
