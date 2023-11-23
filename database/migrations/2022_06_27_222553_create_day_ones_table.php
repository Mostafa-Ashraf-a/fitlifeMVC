<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_ones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercise_id');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');

            $table->unsignedBigInteger('workout_id');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');

            $table->tinyInteger('exercise_type')->nullable()->comment('1 => Pre , 2 => Main, 3 => Post, 4=> Cardio');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_ones');
    }
}
