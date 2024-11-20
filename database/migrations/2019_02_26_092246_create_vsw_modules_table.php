<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('pathmod');
            $table->string('description')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->string('bgmod')->nullable();
            $table->string('icon')->nullable();
            $table->string('groupview')->nullable();
            $table->string('locale');
            $table->string('theme')->nullable();
            $table->integer('weight')->nullable();
            $table->tinyInteger('active');
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
        Schema::dropIfExists('vsw_modules');
    }
}
