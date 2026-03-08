<?php

namespace App\Models\ISPInfo;

use Illuminate\Database\Eloquent\Model;

class ISPModeOfAcq extends Model
{
    protected $table = 'i_s_p_mode_of_acqs';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function ispInfos()
    {
        return $this->hasMany(ISPInfo::class, 'mode_of_acq_id', 'id');
    }
}
