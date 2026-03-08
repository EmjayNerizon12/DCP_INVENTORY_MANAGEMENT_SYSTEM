<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolGradeLevel extends Model
{
    protected $table = 'school_grade_levels';

    protected $primaryKey = 'GradeLevelID';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'GradeLevelID',
        'GradeName',
    ];

    public function schoolData()
    {
        return $this->hasMany(SchoolData::class, 'GradeLevelID', 'GradeLevelID');
    }
}
