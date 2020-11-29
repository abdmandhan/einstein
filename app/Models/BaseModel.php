<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i:s',
    ];



    // protected static function booted()
    // {
    //     static::creating(function ($user) {
    //         DB::unprepared('SET IDENTITY_INSERT ' . (new static)->getTable() . ' ON');
    //     });
    // }
}
