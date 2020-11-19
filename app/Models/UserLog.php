<?php

namespace App\Models;

class UserLog extends BaseModel
{
    protected $casts = [
        'payload'   => 'json'
    ];
}
