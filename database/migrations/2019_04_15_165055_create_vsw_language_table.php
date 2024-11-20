<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_language', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('locale', 20);
            $table->string('script', 20)->nullable();
            $table->string('native', 20)->nullable();
            $table->string('regional', 20)->nullable();
            $table->string('flag', 20)->nullable();
            $table->tinyInteger('default')->unsigned()->default(0);
            $table->tinyInteger('active')->unsigned()->default(0);
            $table->integer('weight')->default(0);
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
        Schema::dropIfExists('vsw_language');
    }
}
