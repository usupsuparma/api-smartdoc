<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('incoming_mails')) {
            Schema::create('incoming_mails', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('type_id')->unsigned();
                $table->bigInteger('classification_id')->unsigned();
                $table->string('number_letter',100)->nullable();
                $table->string('subject_letter');
                $table->string('sender_name');
                $table->string('receiver_name');
                $table->date('letter_date');
                $table->date('recieved_date');
                $table->bigInteger('structure_id')->unsigned()->nullable();
                $table->bigInteger('to_employee_id')->unsigned()->nullable();
                $table->tinyInteger('status');
                $table->tinyInteger('is_recieved');
                $table->date('retension_date');
                $table->string('path_to_file');
                $table->timestamps();
                $table->softDeletes();
            });
        }
        
        if (!Schema::hasTable('incoming_mails_attachment')) {
            Schema::create('incoming_mails_attachment', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('incoming_mail_id')->unsigned();
                $table->string('attachment_name');
                $table->integer('attachment_order');
                $table->string('path_to_file');
                $table->boolean('status');
                $table->timestamps();
                
                $table->foreign('incoming_mail_id')->references('id')->on('incoming_mails')->onDelete('cascade');
            });
        }
        
        if (!Schema::hasTable('incoming_mails_follow_up')) {
            Schema::create('incoming_mails_follow_up', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('incoming_mail_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->text('description');
                $table->string('path_to_file');
                $table->boolean('status');
                $table->timestamps();
                
                $table->foreign('incoming_mail_id')->references('id')->on('incoming_mails')->onDelete('cascade');
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
        Schema::dropIfExists('incoming_mails');
        Schema::dropIfExists('incoming_mails_attachment');
        Schema::dropIfExists('incoming_mails_follow_up');
    }
}
