<?php

namespace App\Models\ISPInfo;

use Illuminate\Database\Eloquent\Model;

class ISPRating extends Model
{
    protected $table = 'i_s_p_ratings';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function ispInfoAdminArea()
    {
        return $this->hasMany(ISPInfo::class, 'admin_area_rate_id', 'id');
    }

    public function ispInfoClassroomArea()
    {
        return $this->hasMany(ISPInfo::class, 'classroom_area_rate_id', 'id');
    }
}
