<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookedSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('booked_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->foreignId('seat_id')->constrained('seats');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booked_seats');
    }
}
