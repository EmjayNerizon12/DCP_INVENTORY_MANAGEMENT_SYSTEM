<?php

namespace App\Models\ISPQ;

use Illuminate\Database\Eloquent\Model;

class ISPAnswer extends Model
{
    protected $table = 'i_s_p_answers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'school_id',
        'question_id',
        'choice_id',
        'other_value',
        'text_value',
        'numeric_value',
        'created_at',
        'updated_at',
    ];

    public function choice()
    {
        return $this->belongsTo(ISPChoice::class, 'choice_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(ISPQuestion::class, 'question_id', 'id');
    }
}
