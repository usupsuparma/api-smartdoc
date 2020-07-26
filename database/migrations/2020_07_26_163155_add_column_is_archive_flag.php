<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsArchiveFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->boolean('is_archive')->after('retension_date')->default(false);
        });
        
        Schema::table('incoming_mails', function (Blueprint $table) {
            $table->boolean('is_archive')->after('is_read')->default(false);
        });
        
        Schema::table('dispositions', function (Blueprint $table) {
            $table->boolean('is_archive')->after('status')->default(false);
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
