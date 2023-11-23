<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_type_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('category_type_id')->unsigned();
            $table->unique(['category_type_id', 'locale']);
            $table->foreign('category_type_id')->references('id')->on('category_types')->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('category_type_translations');
    }
}
