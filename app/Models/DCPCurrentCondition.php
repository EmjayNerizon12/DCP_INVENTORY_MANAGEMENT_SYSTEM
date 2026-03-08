<?php

namespace App\Models;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class DCPCurrentCondition extends Model
{
    use ManagesLookupCrud;

    protected $table = 'dcp_current_conditions';

    protected $primaryKey = 'pk_dcp_current_conditions_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function dcpItemCondition()
    {
        return $this->hasMany(DCPItemCondition::class, 'dcp_current_condition_id', 'pk_dcp_current_conditions_id');
    }
}
