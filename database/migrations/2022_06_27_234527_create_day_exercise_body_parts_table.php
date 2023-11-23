<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayExerciseBodyPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_exercise_body_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workout_id');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');

            $table->unsignedBigInteger('body_part_id');
            $table->foreign('body_part_id')->references('id')->on('body_parts')->onDelete('cascade');

            $table->tinyInteger('day');
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
        Schema::dropIfExists('day_exercise_body_parts');
    }
}
