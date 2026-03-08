<?php

namespace App\Models\SchoolEquipment;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentCategories extends Model
{
    use ManagesLookupCrud;

    protected $table = 'school_equipment_categories';

    protected $primaryKey = 'id';

    public $timestamps = true; // Set false if table doesn't have created_at/updated_at

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function schoolEquipments()
    {
        return $this->hasMany(SchoolEquipment::class, 'category_id', 'id');
    }
}
