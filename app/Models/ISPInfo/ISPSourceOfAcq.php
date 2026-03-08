<?php

namespace App\Models\ISPInfo;

use Illuminate\Database\Eloquent\Model;

class ISPSourceOfAcq extends Model
{
    protected $table = 'i_s_p_source_of_acqs';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function ispInfos()
    {
        return $this->hasMany(ISPInfo::class, 'source_of_acq_id', 'id');
    }
}
