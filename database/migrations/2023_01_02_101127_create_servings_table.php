<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index('user_id');

            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('meal_plans')->onDelete('cascade');
            $table->index('plan_id');

            $table->tinyInteger('status')->default(1)->comment('1 => Master Amount, 2 => Used Amount, 3 => Under Implementation Amount');
            $table->tinyInteger('plan_status')->default(0)->comment('0 => New User, 1 => under construction, 2 => in progress, 3 => archived');

            $table->double('starches');
            $table->double('fruits');
            $table->double('vegetables');
            $table->double('meats');
            $table->double('dairy');
            $table->double('oils');
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
        Schema::dropIfExists('servings');
    }
}
