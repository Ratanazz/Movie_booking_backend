<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable = ['theater_id', 'name', 'seat_capacity'];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}