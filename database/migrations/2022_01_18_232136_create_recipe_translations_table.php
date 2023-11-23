<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('recipe_id')->unsigned();
            $table->unique(['recipe_id', 'locale']);
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->string('title');
            $table->longText('instructions');
            $table->longText('other_info')->nullable();
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
        Schema::dropIfExists('recipe_translations');
    }
}
