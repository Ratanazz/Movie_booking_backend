<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            // Rename poster_url to poster_image for file storage
            $table->renameColumn('poster_url', 'poster_image');
            
            // Add image_banner column for storing banner images
            $table->string('image_banner')->nullable()->after('poster_image');
        });
    }

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            // Revert the column name change
            $table->renameColumn('poster_image', 'poster_url');
            
            // Drop the image_banner column
            $table->dropColumn('image_banner');
        });
    }
};
