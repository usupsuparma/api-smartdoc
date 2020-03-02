<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 100);
                $table->string('categories',20)->nullable();
                $table->boolean('status')->default(1);
                $table->timestamps();
                $table->softDeletes();
                
            });
        }
        
        if (!Schema::hasTable('menu_roles')) {
            Schema::create('menu_roles', function (Blueprint $table) {
                $table->bigInteger('menu_id')->unsigned()->nullable();
                $table->bigInteger('role_id')->unsigned()->nullable();
                $table->boolean('authority_read')->nullable();
                $table->boolean('authority_create')->nullable();
                $table->boolean('authority_update')->nullable();
                $table->boolean('authority_delete')->nullable();
                $table->boolean('authority_import')->nullable();
                $table->boolean('authority_export')->nullable();
                $table->boolean('authority_approve')->nullable();
                $table->boolean('authority_disposition')->nullable();
                $table->tinyInteger('authority_data')->nullable();

                $table->primary(['menu_id', 'role_id']);
                $table->timestamps();
                
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('roles_tables');
    }
}
