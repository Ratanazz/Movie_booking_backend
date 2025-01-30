<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAvailableToSeatsTable extends Migration
{
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            // Add the new column
            $table->boolean('is_available')->default(true)->after('seat_number');
        });
    }

    public function down()
    {
        Schema::table('seats', function (Blueprint $table) {
            // Drop the column if the migration is rolled back
            $table->dropColumn('is_available');
        });
    }
}