<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodExchangeMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_exchange_measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_exchange_id');
            $table->foreign('food_exchange_id')->references('id')->on('food_exchanges')->onDelete('cascade');

            $table->unsignedBigInteger('measurement_unit_id');
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->onDelete('cascade');

            $table->double('quantity')->nullable();
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
        Schema::dropIfExists('food_exchange_measurements');
    }
}
