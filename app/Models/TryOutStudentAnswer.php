<?php

namespace App\Models;

class TryOutStudentAnswer extends BaseModel
{
    public function question()
    {
        return $this->belongsTo(TryOutQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(TryOutAnswer::class, 'answer_id');
    }
}
