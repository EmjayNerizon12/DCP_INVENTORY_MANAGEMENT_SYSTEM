<?php

namespace App\Models;

use App\Models\Equipment\EquipmentBiometricDetails;
use App\Models\ISP\ISPDetails;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';

    protected $primaryKey = 'pk_school_id';

    protected $fillable = [
        'SchoolID',
        'SchoolName',
        'SchoolLevel',
        'total_no_teaching',
        'classroom_with_tv',
        'Region',
        'Division',
        'District',
        'image_path',
        'Province',
        'CityMunicipality',
        'SchoolAddress', // new

        'SchoolContactNumber',
        'SchoolContactNumber2', // new
        'SchoolTelNumber', // new
        'SchoolEmailAddress',

        'admin_position', // new
        'admin_email', // new
        'admin_mobile_no', // new

        'admin_staff_email', // new
        'admin_staff_mobile_no', // new

        'has_network_admin', // 0 or 1
        'has_bandwidth', // 0 or 1

        'created_at',
        'updated_at',
    ];

    public function schoolEquipments()
    {
        return $this->hasMany(SchoolEquipment\SchoolEquipment::class, 'school_id', 'pk_school_id');
    }

    public function dcpBatches()
    {
        return $this->hasMany(DCPBatch::class, 'school_id', 'pk_school_id');
    }

    public function schoolUser()
    {
        return $this->hasOne(SchoolUser::class, 'pk_school_id', 'pk_school_id');
    }

    public function schoolCoordinates()
    {
        return $this->hasOne(SchoolCoordinates::class, 'pk_school_id', 'pk_school_id');
    }

    public function schoolData()
    {
        return $this->hasMany(SchoolData::class, 'pk_school_id', 'pk_school_id');
    }

    public function ispDetails()
    {
        return $this->hasMany(ISPDetails::class, 'school_id', 'pk_school_id');
    }

    public function nonDCPItems()
    {
        return $this->hasMany(NonDCPItem::class, 'school_id', 'pk_school_id');
    }

    public function biometricDetails()
    {
        return $this->hasMany(EquipmentBiometricDetails::class, 'school_id', 'pk_school_id');
    }

    public function schoolOfficials()
    {
        return $this->hasMany(SchoolOfficial::class, 'school_id', 'pk_school_id');
    }
}
