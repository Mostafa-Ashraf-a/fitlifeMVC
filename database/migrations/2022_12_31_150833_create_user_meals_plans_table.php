<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMealsPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meals_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meal_id')->nullable();
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('meal_plans')->onDelete('cascade');

            $table->unsignedBigInteger('food_exchange_id')->nullable();
            $table->foreign('food_exchange_id')->references('id')->on('food_exchanges')->onDelete('cascade');

            $table->integer('quantity')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1 => under construction, 2 => in progress, 3 => archived');

            $table->tinyInteger('type')->default(1)->comment('1 =>custom, 2 => suggested');
            $table->tinyInteger('duration')->nullable()->comment('1 =>daily, 2 => weekly');
            $table->integer('day_number')->nullable();
            $table->integer('week_number')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable(); // date that moved to archived

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
        Schema::dropIfExists('user_meals_plans');
    }
}
