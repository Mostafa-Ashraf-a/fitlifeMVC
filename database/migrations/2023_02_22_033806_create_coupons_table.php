<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->tinyInteger('discount_type')->comment('1 => fixed, 2 => percentage');
            $table->double('discount_value');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit')->default(1);
            $table->integer('usage')->default(0);
            $table->boolean('status')->default(1)->comment('1 => active, 0 => inactive');
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
        Schema::dropIfExists('coupons');
    }
}
