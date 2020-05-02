<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPathToFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incoming_mails', function (Blueprint $table) {
            $table->string('path_to_file')->nullable()->change();
        });
        
        Schema::table('incoming_mails_follow_up', function (Blueprint $table) {
            $table->string('path_to_file')->nullable()->change();
        });
        
        Schema::table('dispositions_follow_up', function (Blueprint $table) {
            $table->string('path_to_file')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
