<?php

namespace App\Models;



class CourseTaskStudent extends BaseModel
{
    public function course_task()
    {
        return $this->belongsTo(CourseTask::class, 'course_task_id');
    }
}
