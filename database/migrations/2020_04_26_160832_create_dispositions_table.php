<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dispositions')) {
            Schema::create('dispositions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('incoming_mail_id')->unsigned();
                $table->string('number_disposition',100)->nullable();
                $table->string('subject_disposition');
                $table->date('disposition_date');
                $table->bigInteger('from_employee_id')->unsigned()->nullable();
                $table->tinyInteger('status');
                $table->string('path_to_file');
                $table->timestamps();
                $table->softDeletes();
            });
        }
        
        if (!Schema::hasTable('dispositions_assign')) {
            Schema::create('dispositions_assign', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('disposition_id')->unsigned();
                $table->bigInteger('structure_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->bigInteger('classification_disposition_id')->unsigned();
                $table->timestamps();
                
                $table->foreign('disposition_id')->references('id')->on('dispositions')->onDelete('cascade');
            });
        }
        
        if (!Schema::hasTable('dispositions_follow_up')) {
            Schema::create('dispositions_follow_up', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('dispositions_assign_id')->unsigned();
                $table->bigInteger('employee_id')->unsigned();
                $table->text('description');
                $table->string('path_to_file');
                $table->boolean('status');
                $table->timestamps();
                
                $table->foreign('dispositions_assign_id')->references('id')->on('dispositions_assign')->onDelete('cascade');
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
        Schema::dropIfExists('dispositions');
        Schema::dropIfExists('dispositions_assign');
        Schema::dropIfExists('dispositions_follow_up');
    }
}
