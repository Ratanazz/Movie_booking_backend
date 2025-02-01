<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowIdToBookedSeatsTable extends Migration
{
 public function up()
 {
 Schema::table('booked_seats', function (Blueprint $table) {
 $table->foreignId('show_id')->constrained('shows')->after('seat_id');
 });
 }

 public function down()
 {
 Schema::table('booked_seats', function (Blueprint $table) {
 $table->dropForeign(['show_id']);
 $table->dropColumn('show_id');
 });
 }
}

