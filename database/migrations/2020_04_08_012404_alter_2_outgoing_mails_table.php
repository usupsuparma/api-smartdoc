<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alter2OutgoingMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->bigInteger('publish_by_employee')->unsigned()->nullable()->after('created_by_structure');
        });
        
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->dateTime('publish_date')->nullable()->after('publish_by_employee');
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
