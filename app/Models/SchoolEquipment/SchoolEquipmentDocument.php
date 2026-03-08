<?php

namespace App\Models\SchoolEquipment;

use Illuminate\Database\Eloquent\Model;

class SchoolEquipmentDocument extends Model
{
    protected $table = 'school_equipment_documents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'school_equipment_id',
        'document_type_id',
        'document_number',
        'created_at',
        'updated_at',
    ];

    public function documentType()
    {
        return $this->belongsTo(SchoolEquipmentDocumentType::class, 'document_type_id', 'id');
    }

    public function schoolEquipment()
    {
        return $this->belongsTo(SchoolEquipment::class, 'school_equipment_id', 'id');
    }
}
