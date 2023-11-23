<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('plan_management_id');
            $table->foreign('plan_management_id')->references('id')->on('plan_management')->onDelete('cascade');

            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

            $table->dateTime('subscribed_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            $table->dateTime('free_trail_start')->nullable();
            $table->dateTime('free_trail_end')->nullable();

            $table->string('transaction_number')->nullable();
            $table->string('card_brand')->nullable();
            $table->integer('card_first_six')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_free')->default(1)->comment('0 => paid , 1 => free');
            $table->string('coupon_code')->nullable();
            $table->tinyInteger('coupon_discount_type')->nullable();
            $table->double('coupon_discount_value')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
}
