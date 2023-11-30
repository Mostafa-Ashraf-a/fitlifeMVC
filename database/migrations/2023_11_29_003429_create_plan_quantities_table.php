<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_quantities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id');
            $table->foreignId('user_id');
            $table->foreignId('recipe_id');
            $table->foreignId('food_exchange_id');
            $table->foreignId('food_type_id');
            $table->foreignId('measurement_unit_id');
            $table->float('quantity');
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
        Schema::dropIfExists('plan_quantities');
    }
}
