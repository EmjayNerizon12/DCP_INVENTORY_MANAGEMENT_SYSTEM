<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolOfficial extends Model
{
    protected $table = 'school_officials';

    protected $fillable = ['school_id', 'school_head', 'ict_coordinator', 'property_custodian'];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'pk_school_id');
    }

    public function schoolHead()
    {
        return $this->belongsTo(SchoolEmployee::class, 'school_head', 'pk_schools_employee_id');
    }

    public function ictCoordinator()
    {
        return $this->belongsTo(SchoolEmployee::class, 'ict_coordinator', 'pk_schools_employee_id');
    }

    public function propertyCustodian()
    {
        return $this->belongsTo(SchoolEmployee::class, 'property_custodian', 'pk_schools_employee_id');
    }
}
