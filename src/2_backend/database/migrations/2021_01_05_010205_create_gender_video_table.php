<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenderVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gender_video', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->uuid('gender_id');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->uuid('video_id');
            $table->foreign('video_id')->references('id')->on('videos');
            $table->unique(['gender_id','video_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gender_video');
    }
}
