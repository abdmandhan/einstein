<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\Auth;

class TryOut extends BaseModel
{
    protected $appends = [
        'question_count',
        'timestamp'
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

    public function tryout_student()
    {
        return $this->hasMany(TryOutStudent::class);
    }

    public function getTimestampAttribute()
    {
        //hitung udah berapa lama dari start_time sampe skrng
        $init1 = new DateTime($this->time);
        $start = date('H:i:s', strtotime($this->date_start));
        $init2 = new DateTime($start);

        $interval = $init1->diff($init2);

        $time_seconds = convertTimeToSeconds($interval->format('%H:%i:%s'));

        // de([$interval->format('%H:%i:%s'), $this->time, $start]);

        return $time_seconds * 1000;
    }

    public function getStudentAssignAttribute()
    {
        return $this->tryout_student()->with([
            'tryout_student_answer.question',
            'tryout_student_answer.answer',
        ])->where('user_id', Auth::id())->first();
    }
}
