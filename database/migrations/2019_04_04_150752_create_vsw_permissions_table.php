<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('superadmin')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_permissions_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('per_id')->nullable();
            $table->string('modules')->nullable();
            $table->boolean('view')->nullable();
            $table->boolean('add')->nullable();
            $table->boolean('delete')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vsw_permissions');
        Schema::dropIfExists('vsw_permissions_roles');
    }
}
