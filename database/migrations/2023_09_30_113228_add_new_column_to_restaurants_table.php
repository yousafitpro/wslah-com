<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('home_page_text')->nullable();
            $table->string('social_media')->nullable();
            $table->string('background_color')->nullable();
            $table->string('frame_color')->nullable();
            $table->string('bg_frame_color')->nullable();
            $table->string('static_logo')->nullable();
            $table->string('is_on_off')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            //
        });
    }
};
