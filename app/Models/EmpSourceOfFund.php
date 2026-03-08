<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class EmpSourceOfFund extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_employee_source_of_funds';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function employees()
    {
        return $this->hasMany(SchoolEmployee::class, 'sources_of_fund_id', 'id');
    }
}
