<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSourceIncomingOutgoing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->tinyInteger('source')->after('is_archive')->default(1);
        });
        
        Schema::table('incoming_mails', function (Blueprint $table) {
            $table->tinyInteger('source')->after('is_archive')->default(2);
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
