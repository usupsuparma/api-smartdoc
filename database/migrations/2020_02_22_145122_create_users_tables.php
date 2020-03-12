<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_core_id')->nullable()->unsigned();
                $table->bigInteger('employee_id')->nullable()->unsigned();
                $table->bigInteger('role_id')->nullable()->unsigned();
                $table->string('email',100);
                $table->string('username',100);
                $table->string('password');
                $table->string('remember_token')->nullable();
                $table->string('public_token')->nullable();
                $table->string('private_token')->nullable();
                $table->string('device_id')->nullable();
                $table->datetime('last_login')->nullable();
                $table->date('log_date')->nullable();
                $table->tinyInteger('count_login')->default(0);
                $table->boolean('is_banned')->default(0);
                $table->boolean('status')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
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
