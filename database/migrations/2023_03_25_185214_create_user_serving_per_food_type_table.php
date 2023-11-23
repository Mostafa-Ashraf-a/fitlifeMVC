<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserServingPerFoodTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_serving_per_food_type', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');

            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('meal_plans')->onDelete('cascade');
            $table->index('plan_id');

            $table->tinyInteger('status')->comment('1 => used, 2 => under implementation, 3 => history');
            $table->tinyInteger('duration')->default(1)->comment('1 => Daily, 2 => Weekly');
            $table->integer('day_number');
            $table->double('Starches')->default(0);
            $table->double('Fruits')->default(0);
            $table->double('Vegetables')->default(0);
            $table->double('Meats')->default(0);
            $table->double('Dairy')->default(0);
            $table->double('Oils')->default(0);

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
        Schema::dropIfExists('user_serving_per_food_type');
    }
}
