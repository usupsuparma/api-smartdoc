<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('heading')->nullable();
                $table->string('title')->nullable();
                $table->text('content')->nullable();
                $table->text('data')->nullable();
                $table->string('redirect_web')->nullable();
                $table->string('redirect_mobile')->nullable();
                $table->bigInteger('sender_id')->unsigned()->nullable();
                $table->bigInteger('receiver_id')->unsigned()->nullable();
                $table->boolean('is_read')->default(0);
                $table->timestamps();
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
        Schema::dropIfExists('notifications');
    }
}
