<?php

namespace App\Models;

class Course extends BaseModel
{
    public function course_content()
    {
        return $this->hasMany(CourseContent::class, 'course_id');
    }

    public function course_task()
    {
        return $this->hasMany(CourseTask::class, 'course_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
