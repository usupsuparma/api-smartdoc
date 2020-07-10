<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIsReadIncoming extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incoming_mails', function (Blueprint $table) {
            $table->boolean('is_read')->after('retension_date')->default(false);
        });
        
        Schema::table('dispositions_assign', function (Blueprint $table) {
            $table->boolean('is_read')->after('classification_disposition_id')->default(false);
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
