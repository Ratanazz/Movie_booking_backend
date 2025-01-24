<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTheaterIdToScreensTable extends Migration
{
    public function up()
    {
        Schema::table('screens', function (Blueprint $table) {
            $table->foreignId('theater_id')
                  ->constrained('theaters')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('screens', function (Blueprint $table) {
            $table->dropForeign(['theater_id']);
            $table->dropColumn('theater_id');
        });
    }
}
