<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswModLayoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_modlayout', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('func_id');
            $table->string('funcname');
            $table->string('layout');
            $table->string('module');
            $table->string('theme');
            $table->string('locale');
            // $table->unique(['func_id', 'layout','theme']);
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
        Schema::dropIfExists('vsw_modlayout');
    }
}
