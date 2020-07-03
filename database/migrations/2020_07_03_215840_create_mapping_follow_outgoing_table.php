<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingFollowOutgoingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mapping_follow_outgoing')) {
            Schema::create('mapping_follow_outgoing', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('type_id')->unsigned();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::dropIfExists('mapping_follow_outgoing');
    }
}
