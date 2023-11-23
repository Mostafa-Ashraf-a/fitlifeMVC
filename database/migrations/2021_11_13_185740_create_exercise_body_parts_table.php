<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciseBodyPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_body_parts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exercise_id')->unsigned();
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');

            $table->bigInteger('body_part_id')->unsigned();
            $table->foreign('body_part_id')->references('id')->on('body_parts')->onDelete('cascade');

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
        Schema::dropIfExists('exercise_body_parts');
    }
}
