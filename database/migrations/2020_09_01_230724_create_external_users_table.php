<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('email', 100);
            $table->bigInteger('id_employee')->unsigned();
            $table->bigInteger('kode_struktur')->unsigned();
            $table->bigInteger('kode_jabatan')->unsigned();
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
        Schema::dropIfExists('external_users');
    }
}
