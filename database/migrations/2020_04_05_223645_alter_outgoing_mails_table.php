<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOutgoingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->renameColumn('approval_id', 'current_approval_employee_id');
        });
        
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->bigInteger('current_approval_sctructure_id')->unsigned()->nullable()->after('current_approval_employee_id');
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
