<?php

namespace App\Models;

class Absensi extends BaseModel
{
    protected $appends = [
        'start',
        'end'
    ];

    protected $casts = [
        'timed' => 'boolean'
    ];

    public function getStartAttribute()
    {
        return strtotime($this->date);
    }

    public function getEndAttribute()
    {
        return strtotime($this->date);
    }
}
