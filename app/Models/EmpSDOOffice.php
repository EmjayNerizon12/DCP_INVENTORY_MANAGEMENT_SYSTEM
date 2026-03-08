<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EmpSDOOffice extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_employee_sdo_office';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function employees()
    {
        return $this->hasMany(SchoolEmployee::class, 'sdo_office_id', 'id');
    }
}
