<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorRetensionDateField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->dropColumn('retension_date');
        });
        
        Schema::table('incoming_mails', function (Blueprint $table) {
            $table->dropColumn('retension_date');
        });
        
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->date('retension_date')->after('signed')->nullable()->default(null);
        });
        
        Schema::table('incoming_mails', function (Blueprint $table) {
            $table->date('retension_date')->after('is_recieved')->nullable()->default(null);
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
