<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserExternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bijb')->table('users', function (Blueprint $table) {
            $table->dropColumn('kode_struktur');
        });
        
        Schema::connection('bijb')->table('users', function (Blueprint $table) {
            $table->bigInteger('kode_struktur')->nullable()->after('id_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
