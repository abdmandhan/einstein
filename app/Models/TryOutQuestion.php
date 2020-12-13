<?php

namespace App\Models;

class TryOutQuestion extends BaseModel
{
    public function try_out_answer()
    {
        return $this->hasMany(TryOutAnswer::class, 'try_out_question_id');
    }
}
