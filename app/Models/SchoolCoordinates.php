<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolCoordinates extends Model
{
    protected $table = 'school_coordinates';

    protected $primaryKey = 'CoordID';

    protected $fillable = [

        'pk_school_id',
        'Latitude',
        'Longitude',
        'is_considered_remote', // 0 or 1
        'uacs', // string
        'created_at',
        'updated_at',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'pk_school_id', 'pk_school_id');
    }
}
