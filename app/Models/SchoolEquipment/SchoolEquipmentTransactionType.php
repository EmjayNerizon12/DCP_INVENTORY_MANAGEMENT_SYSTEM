<?php

namespace App\Models\SchoolEquipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentTransactionType extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_equipment_transaction_types';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function accountabilities()
    {
        return $this->hasMany(SchoolEquipmentAccountabilty::class, 'transaction_type_id', 'id');
    }
}
