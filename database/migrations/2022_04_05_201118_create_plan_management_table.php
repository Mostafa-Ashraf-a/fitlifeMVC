<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_duration_id');
            $table->foreign('plan_duration_id')->references('id')->on('plan_durations')->onDelete('cascade');

            $table->integer('trail_period')->default(0);
            $table->string('trail_interval')->default('day');
            $table->double('price')->nullable();
            $table->string('currency')->default('SAR');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('plan_management');
    }
}
