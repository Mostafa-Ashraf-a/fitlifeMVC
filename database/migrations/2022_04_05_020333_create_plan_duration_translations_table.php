<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanDurationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_duration_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('plan_duration_id')->unsigned();
            $table->unique(['plan_duration_id', 'locale']);
            $table->foreign('plan_duration_id')->references('id')->on('plan_durations')->onDelete('cascade');
            $table->string('duration_name');
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
        Schema::dropIfExists('plan_duration_translations');
    }
}
