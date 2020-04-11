<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alter4OutgoingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->renameColumn('current_approval_sctructure_id', 'current_approval_structure_id');
        });
        
        Schema::table('outgoing_mails_attachment', function (Blueprint $table) {
            $table->dropForeign(['outgoing_mail_id']);
        });
        
        Schema::table('outgoing_mails_attachment', function (Blueprint $table) {
            $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails')->onDelete('cascade');
        });
        
        Schema::table('outgoing_mails_forward', function (Blueprint $table) {
            $table->dropForeign(['outgoing_mail_id']);
        });
        
        Schema::table('outgoing_mails_forward', function (Blueprint $table) {
            $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails')->onDelete('cascade');
        });
        
        Schema::table('outgoing_mails_approval', function (Blueprint $table) {
            $table->dropForeign(['outgoing_mail_id']);
        });
        
        Schema::table('outgoing_mails_approval', function (Blueprint $table) {
            $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails')->onDelete('cascade');
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
