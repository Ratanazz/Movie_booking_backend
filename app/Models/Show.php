<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $fillable = ['movie_id', 'screen_id', 'show_time', 'price'];
    
    protected $casts = [
        'show_time' => 'datetime'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function bookedSeats()
    {
        return BookedSeat::whereIn('booking_id', $this->bookings->pluck('id'));
    }

    public function getAvailableSeats()
    {
        $screen = $this->screen;
        $bookedSeatIds = $this->bookedSeats()->pluck('seat_id');
        return Seat::where('screen_id', $screen->id)
                  ->whereNotIn('id', $bookedSeatIds)
                  ->get();
    }
}
