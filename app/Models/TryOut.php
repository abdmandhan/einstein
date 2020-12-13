<?php

namespace App\Models;

class TryOut extends BaseModel
{
    protected $appends = [
        'question_count'
    ];

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function getQuestionCountAttribute()
    {
        return $this->try_out_question()->get()->count();
    }

    public function try_out_question()
    {
        return $this->hasMany(TryOutQuestion::class);
    }
}
