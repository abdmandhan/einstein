<?php

namespace App\Models;

class UserTeacher extends BaseModel
{

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }
}
