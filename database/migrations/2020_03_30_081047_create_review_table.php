<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code',10);
                $table->string('name');
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('review_details')) {
            Schema::create('review_details', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('review_id')->unsigned();
                $table->bigInteger('structure_id')->unsigned();
                $table->tinyInteger('order')->nullable();
                $table->timestamps();
                
                $table->foreign('review_id')->references('id')->on('reviews');
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
        Schema::dropIfExists('review_details');
        Schema::dropIfExists('reviews');
    }
}
