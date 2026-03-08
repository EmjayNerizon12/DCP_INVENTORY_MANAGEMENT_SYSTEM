<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    use ManagesLookupCrud;

    protected $table = 'position_title';

    protected $primaryKey = 'pk_school_position_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function schoolEmployees()
    {
        return $this->hasMany(SchoolEmployee::class, 'position_title_id', 'pk_school_position_id');
    }
}
