<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDigitalSignatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_signatures', function (Blueprint $table) {
            $table->string('path_public_key')->nullable()->after('path_to_file');
        });
        
        Schema::table('digital_signatures', function (Blueprint $table) {
            $table->string('path_private_key')->nullable()->after('path_public_key');
        });
        
        Schema::table('digital_signatures', function (Blueprint $table) {
            $table->string('credential_key')->nullable()->after('path_private_key');
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
