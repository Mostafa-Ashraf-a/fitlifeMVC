<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCalculationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_calculation_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('macronutrients_amount_answer')->nullable();
            $table->double('protein_intake')->nullable();
            $table->double('carbs_intake')->nullable();
            $table->double('fats_intake')->nullable();
            $table->integer('body_fat_percentage_answer')->nullable();
            $table->double('waist_circumference')->nullable();
            $table->double('neck_circumference')->nullable();
            $table->double('hip_circumference')->nullable();
            $table->double('weight_before_training')->nullable();
            $table->double('weight_after_training')->nullable();
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
        Schema::dropIfExists('user_calculation_fields');
    }
}
