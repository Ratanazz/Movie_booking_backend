<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'show_id', 'total_price', 'booking_date'];

    protected $casts = [
        'booking_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function bookedSeats()
    {
        return $this->hasMany(BookedSeat::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

