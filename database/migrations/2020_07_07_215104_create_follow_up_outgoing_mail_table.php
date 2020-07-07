<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowUpOutgoingMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('outgoing_mails_assign')) {
            Schema::create('outgoing_mails_assign', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('outgoing_mail_id')->unsigned();
                $table->bigInteger('structure_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->timestamps();
                
                $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails')->onDelete('cascade');
            });
        }
        
        if (!Schema::hasTable('outgoing_mails_follow_up')) {
            Schema::create('outgoing_mails_follow_up', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('outgoing_mails_assign_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->text('description');
                $table->string('path_to_file');
                $table->boolean('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outgoing_mails_follow_up');
        Schema::dropIfExists('outgoing_mails_assign');
    }
}
