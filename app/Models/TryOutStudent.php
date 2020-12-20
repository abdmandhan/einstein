<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class TryOutStudent extends BaseModel
{
    public function tryout_student_answer()
    {
        return $this->hasMany(TryOutStudentAnswer::class, 'try_out_id')->where('user_id', Auth::id());
    }

    public function tryout()
    {
        return $this->belongsTo(TryOut::class, 'try_out_id');
    }
}
