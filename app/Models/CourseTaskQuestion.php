<?php

namespace App\Models;



class CourseTaskQuestion extends BaseModel
{
    public function course_task_answer()
    {
        return $this->hasMany(CourseTaskQuestion::class, 'course_task_question_id');
    }
}
