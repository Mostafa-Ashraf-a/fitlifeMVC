<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanMealTypesMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_meal_types_meals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('meal_plan_id');
            $table->foreign('meal_plan_id')->references('id')->on('meal_plans')->onDelete('cascade');

            $table->unsignedBigInteger('meal_type_id');
            $table->foreign('meal_type_id')->references('id')->on('meal_types')->onDelete('cascade');

            $table->unsignedBigInteger('meal_id');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');

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
        Schema::dropIfExists('plan_meal_types_meals');
    }
}
