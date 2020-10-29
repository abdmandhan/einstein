<?php

namespace App\Models;



class CourseTeacher extends BaseModel
{

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
