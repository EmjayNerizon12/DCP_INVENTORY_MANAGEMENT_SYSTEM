<?php

namespace App\Models\ISP;

use Illuminate\Database\Eloquent\Model;

class ISPSpeedTest extends Model
{
    protected $table = 'isp_speed_test';

    protected $primaryKey = 'pk_isp_speed_test_id';

    protected $fillable = [
        'isp_details_id',
        'upload',
        'download',
        'ping',
        'created_at',
        'updated_at',
    ];

    public function ispDetails()
    {
        return $this->belongsTo(ISPDetails::class, 'isp_details_id', 'pk_isp_details_id');
    }
}
