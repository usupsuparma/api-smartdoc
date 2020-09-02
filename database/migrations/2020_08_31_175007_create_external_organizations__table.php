<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->nullable();
            $table->string('kode_struktur',100);
            $table->string('nama_struktur',100);
            $table->integer('order')->nullable();
            $table->boolean('status')->deafult(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_organizations');
    }
}
