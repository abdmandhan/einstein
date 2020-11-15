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
}
