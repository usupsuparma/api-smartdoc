<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMappingStructurePositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mapping_structure')) {
            Schema::create('mapping_structure', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 10);
                $table->string('name');
                $table->bigInteger('primary_top_level_id')->unsigned()->nullable();
                $table->bigInteger('secondary_top_level_id')->unsigned()->nullable();
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('mapping_structure_detail')) {
            Schema::create('mapping_structure_detail', function (Blueprint $table) {
                $table->bigInteger('mapping_structure_id')->unsigned()->nullable();
                $table->bigInteger('structure_id')->unsigned()->nullable();
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
        Schema::dropIfExists('mapping_structure_position');
    }
}
