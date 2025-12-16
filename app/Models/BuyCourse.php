<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyCourse extends Model
{
    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }
}
