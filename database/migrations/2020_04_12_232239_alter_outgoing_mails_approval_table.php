<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOutgoingMailsApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outgoing_mails_approval', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->tinyInteger('is_review')->nullable()->after('description');
        });
        
        Schema::table('outgoing_mails_approval', function (Blueprint $table) {
            $table->tinyInteger('status')->nullable()->after('is_review');
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
