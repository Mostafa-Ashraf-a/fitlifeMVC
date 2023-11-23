<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('added_by')->default(1)->comment('1 => Added By Admin, 2 => Added By Customer');

            $table->unsignedBigInteger('goal_id')->nullable();
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');

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
        Schema::dropIfExists('meal_plans');
    }
}
