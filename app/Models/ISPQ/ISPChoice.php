<?php

namespace App\Models\ISPQ;

use Illuminate\Database\Eloquent\Model;

class ISPChoice extends Model
{
    protected $table = 'i_s_p_choices';

    protected $primaryKey = 'id';

    protected $fillable = [
        'choice_text', // YES , NO , GLOBE , PLDT
        'choice_value', // FOR TYES OR NO, STORES BOOLEAN
        'is_other', // IF THE CHOICE IS "OTHER", THIS WILL BE TRUE (1)
        'created_at',
        'updated_at',
    ];

    public function question()
    {
        return $this->belongsTo(ISPQuestion::class, 'question_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(ISPAnswer::class, 'choice_id', 'id');
    }
}
