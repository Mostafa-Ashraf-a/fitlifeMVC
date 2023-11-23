<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanManagementTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_management_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->bigInteger('plan_management_id')->unsigned();
            $table->unique(['plan_management_id', 'locale']);
            $table->foreign('plan_management_id')->references('id')->on('plan_management')->onDelete('cascade');
            $table->string('plan_name');
            $table->longText('description')->nullable();
            $table->longText('features')->nullable();
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
        Schema::dropIfExists('plan_management_translations');
    }
}
