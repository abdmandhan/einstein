<?php

namespace App\Models;

class Transaction extends BaseModel
{
    public function transaction_status()
    {
        return $this->belongsTo(TransactionStatus::class, 'transaction_status_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserNameAttribute()
    {
        return $this->user()->first()->name;
    }

    public function getCourseNameAttribute()
    {
        return $this->course()->first()->name;
    }

    public function getTransactionStatusNameAttribute()
    {
        return $this->transaction_status()->first()->name;
    }
}
