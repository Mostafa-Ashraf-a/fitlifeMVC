<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('daily_calories_goal')->nullable();
            $table->double('min_daily_calories')->nullable();
            $table->double('max_daily_calories')->nullable();
            $table->double('body_mass_index')->nullable();
            $table->string('body_mass_index_text')->nullable();

            $table->double('protein_calories')->nullable();
            $table->double('carbs_calories')->nullable();
            $table->double('fats_calories')->nullable();

            $table->double('protein_grams')->nullable();
            $table->double('carbs_grams')->nullable();
            $table->double('fats_grams')->nullable();

            $table->double('approximated_body_fat_percentage_based_on_bmi')->nullable();


            $table->double('new_macronutrients_in_calories_protein')->nullable();
            $table->double('new_macronutrients_in_calories_carbs')->nullable();
            $table->double('new_macronutrients_in_calories_fats')->nullable();

            $table->double('new_macronutrients_in_grams_protein')->nullable();
            $table->double('new_macronutrients_in_grams_carbs')->nullable();
            $table->double('new_macronutrients_in_grams_fats')->nullable();


            $table->double('body_fat_percentage_yes')->nullable();
            $table->double('fat_mass_yes')->nullable();
            $table->double('lean_mass_yes')->nullable();

            $table->double('body_fat_percentage_no')->nullable();
            $table->double('fat_mass_no')->nullable();
            $table->double('lean_mass_no')->nullable();


            $table->double('water_intake_after_exercise')->nullable();


            $table->double('starches')->nullable();
            $table->double('fruits')->nullable();
            $table->double('vegetables')->nullable();
            $table->double('meats')->nullable();
            $table->double('dairy')->nullable();
            $table->double('oils')->nullable();
            $table->double('total_calories')->nullable();
            $table->double('total_protein')->nullable();
            $table->double('total_carbs')->nullable();
            $table->double('total_fats')->nullable();
            $table->double('starches_result')->nullable();
            $table->double('fruits_result')->nullable();
            $table->double('vegetables_result')->nullable();
            $table->double('meats_result')->nullable();
            $table->double('dairy_result')->nullable();
            $table->double('oils_result')->nullable();


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
        Schema::dropIfExists('calculation_results');
    }
}
