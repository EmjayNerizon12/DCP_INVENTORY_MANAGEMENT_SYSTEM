<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundSource extends Model
{
    protected $table = 'fund_source';

    protected $primaryKey = 'pk_fund_source_id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function non_dcp_item()
    {
        return $this->hasMany(NonDCPItem::class, 'fund_source_id', 'pk_fund_source_id');
    }
}
