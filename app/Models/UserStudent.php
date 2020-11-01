<?php

namespace App\Models;

class UserStudent extends BaseModel
{
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
