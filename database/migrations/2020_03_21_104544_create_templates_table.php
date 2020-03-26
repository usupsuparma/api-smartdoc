<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('templates')) {
            Schema::create('templates', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 100);
                $table->bigInteger('type_id')->unsigned();
                $table->longText('template');
                $table->boolean('status')->default(1);
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
        Schema::dropIfExists('templates');
    }
}
