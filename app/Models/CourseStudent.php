<?php

namespace App\Models;



class CourseStudent extends BaseModel
{
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
