<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOutgoingMailApproval1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails_approval', function (Blueprint $table) {
            $table->dropColumn('status_approval');
        });
        
        Schema::table('outgoing_mails_approval', function (Blueprint $table) {
            $table->tinyInteger('status_approval')->nullable()->after('structure_id');
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
