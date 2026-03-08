<?php

namespace App\Models\ISP;

use App\Models\Concerns\ManagesLookupCrud;
use Illuminate\Database\Eloquent\Model;

class ISPList extends Model
{
    use ManagesLookupCrud;

    protected $table = 'isp_list';

    protected $primaryKey = 'pk_isp_list_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function ispDetails()
    {
        return $this->hasMany(ISPDetails::class, 'isp_list_id', 'pk_isp_list_id');
    }
}
