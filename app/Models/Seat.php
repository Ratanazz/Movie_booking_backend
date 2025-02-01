<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seat extends Model
{   use HasFactory;
    protected $fillable = ['screen_id', 'seat_number', 'is_vip'];

    
    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booked_seats');
    }
    public function bookedSeats()
    {
        return $this->hasMany(BookedSeat::class);
    }

}