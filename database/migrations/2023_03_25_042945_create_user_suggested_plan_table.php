<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSuggestedPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_suggested_plan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('meal_plans')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('meal_type_id');
            $table->foreign('meal_type_id')->references('id')->on('meal_types')->onDelete('cascade');

            $table->unsignedBigInteger('recipe_id');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');

            $table->tinyInteger('duration')->default(1)->comment('1 => Daily, 2 => Weekly');

            $table->date('start_date');
            $table->date('end_date');
            $table->double('cal')->default(0);
            $table->double('proteins')->default(0);
            $table->double('carbs')->default(0);
            $table->double('fats')->default(0);
            $table->integer('day_number')->default(1);
            $table->boolean('status')->default(1)->comment('1 => active, 0 => History');

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
        Schema::dropIfExists('user_suggested_plan');
    }
}
