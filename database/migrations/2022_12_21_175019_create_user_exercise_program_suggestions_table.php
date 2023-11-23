<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExerciseProgramSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_exercise_program_suggestions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');

            $table->unsignedBigInteger('body_part_id')->nullable();
            $table->foreign('body_part_id')->references('id')->on('body_parts')->onDelete('cascade');

            $table->unsignedBigInteger('exercise_id')->nullable();
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');

            $table->unsignedBigInteger('exercise_type_id')->nullable();
            $table->foreign('exercise_type_id')->references('id')->on('exercise_types')->onDelete('cascade');

            $table->date('start_at');
            $table->date('end_at');

            $table->tinyInteger('program_duration')->comment('1 => daily, 2 => weekly');
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
        Schema::dropIfExists('user_exercise_program_suggestions');
    }
}
