<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->integer('mobile')->unique();
            $table->index(['mobile','created_at']);
            $table->string('password');
            $table->integer('age')->nullable();
            $table->tinyInteger('gender')->nullable()->comment("1 => male, 2 => female");
            $table->string('image')->nullable();
            $table->tinyInteger('user_type')->default(1)->comment("1 => customers");
            $table->integer('otp_code');
            $table->tinyInteger('otp_count')->default(0);
            $table->integer('is_verified')->default(0)->comment("0=>pending , 1=>verified");
            $table->tinyInteger('status')->default(1)->comment("1=>active , 0=>rejected");
            $table->tinyInteger('goal')->nullable()->comment("(gain = 1 | maintain = 2 | lose = 3)");
            $table->tinyInteger('level')->nullable()->comment("(8 => Beginner , 9 => Intermediate, 10 => Expert)");

            $table->double('weight')->nullable();
            $table->double('height')->nullable();

            $table->time('serving_reset_time')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
