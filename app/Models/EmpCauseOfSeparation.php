<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EmpCauseOfSeparation extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_employee_cause_of_separations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function employees()
    {
        return $this->hasMany(SchoolEmployee::class, 'cause_of_separation_id', 'id');
    }
}
