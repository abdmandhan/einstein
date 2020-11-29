<?php

namespace App\Models;

class DiscussReply extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('name');
    }
}
