<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class DCPItemAssignedType extends Model
{
    use ManagesLookupCrud;

    protected $table = 'dcp_assignment_types';

    protected $primaryKey = 'pk_dcp_assignment_types_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function dcpAssignedUsers()
    {
        return $this->hasMany(DCPItemAssignedUser::class, 'assignment_type_id', 'pk_dcp_assignment_types_id');
    }
}
