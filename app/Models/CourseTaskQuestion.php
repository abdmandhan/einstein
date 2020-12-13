<?php

namespace App\Models;



class CourseTaskQuestion extends BaseModel
{
    public function course_task_answer()
    {
        return $this->hasMany(CourseTaskAnswer::class, 'course_task_question_id');
    }

    public function getTrueAnswerAttribute()
    {
        return $this->course_task_answer()->where('is_true', '1')->first();
    }

    protected $appends = [
        'true_answer'
    ];
}
