<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('outgoing_mails')) {
            Schema::create('outgoing_mails', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('number_letter',100)->nullable();
                $table->string('subject_letter');
                $table->bigInteger('type_id')->unsigned();
                $table->bigInteger('classification_id')->unsigned();
                $table->date('letter_date');
                $table->bigInteger('to_employee_id')->unsigned()->nullable();
                $table->bigInteger('from_employee_id')->unsigned();
                $table->longText('body');
                $table->tinyInteger('status');
                $table->boolean('signed');
                $table->date('retension_date');
                $table->string('path_to_file');
                $table->bigInteger('approval_id')->unsigned()->nullable();
                $table->bigInteger('created_by_employee')->unsigned();
                $table->bigInteger('created_by_structure')->unsigned();
                $table->timestamps();
                $table->softDeletes();
            });
        }
        
        if (!Schema::hasTable('outgoing_mails_attachment')) {
            Schema::create('outgoing_mails_attachment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('outgoing_mail_id')->unsigned();
                $table->string('attachment_name');
                $table->integer('attachment_order');
                $table->string('path_to_file');
                $table->boolean('status');
                $table->timestamps();
                
                $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails');
            });
        }
        
        if (!Schema::hasTable('outgoing_mails_forward')) {
            Schema::create('outgoing_mails_forward', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('outgoing_mail_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->timestamps();
                
                $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails');
                
            });
        }
        
        if (!Schema::hasTable('outgoing_mails_approval')) {
            Schema::create('outgoing_mails_approval', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('outgoing_mail_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->tinyInteger('status_approval');
                $table->text('description');
                $table->timestamps();
                
                $table->foreign('outgoing_mail_id')->references('id')->on('outgoing_mails');
                
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
        Schema::dropIfExists('outgoing_mails_approval');
        Schema::dropIfExists('outgoing_mails_forward');
        Schema::dropIfExists('outgoing_mails_attachment');
        Schema::dropIfExists('outgoing_mails');
    }
}
