<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciseTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('exercise_id')->unsigned();
            $table->unique(['exercise_id', 'locale']);
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');
            $table->string('title');
            $table->longText('tips')->nullable();
            $table->longText('instructions')->nullable();
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
        Schema::dropIfExists('exercise_translations');
    }
}
