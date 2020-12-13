<?php

namespace App\Models;

class CourseTask extends BaseModel
{
    public function course_task_question()
    {
        return $this->hasMany(CourseTaskQuestion::class, 'course_task_id');
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function course_task_student_answer()
    {
        return $this->hasMany(CourseTaskStudentAnswer::class, 'task_id');
    }
}
