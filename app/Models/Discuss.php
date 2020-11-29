<?php

namespace App\Models;

class Discuss extends BaseModel
{
    public function replies()
    {
        return $this->hasMany(DiscussReply::class, 'discuss_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }
}
