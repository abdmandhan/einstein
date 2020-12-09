<?php

namespace App\Models;



class CourseStudent extends BaseModel
{
    protected $casts = [
        'is_complete'    => 'boolean'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
