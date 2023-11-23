<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMealTypeFoodExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meal_type_food_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('meal_type_id');
            $table->foreign('meal_type_id')->references('id')->on('meal_types')->onDelete('cascade');

            $table->unsignedBigInteger('food_exchange_id');
            $table->foreign('food_exchange_id')->references('id')->on('food_exchanges')->onDelete('cascade');

            $table->date('date');
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
        Schema::dropIfExists('user_meal_type_food_exchanges');
    }
}
