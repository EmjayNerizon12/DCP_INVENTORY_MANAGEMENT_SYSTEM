<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolData extends Model
{
    protected $table = 'school_grade_data';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        'pk_school_id',
        'GradeLevelID',
        'RegisteredLearners',
        'Teachers',
        'Sections',
        'Classrooms',
        'NonTeachingPersonnel',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'pk_school_id', 'pk_school_id');
    }
}
