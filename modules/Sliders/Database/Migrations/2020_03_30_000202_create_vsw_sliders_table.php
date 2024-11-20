<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CreateVswSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('groupid');
            $table->string('title');
            $table->string('description', 400)->nullable();
            $table->string('image');
            $table->string('link')->nullable();
            $table->string('custom_id')->nullable();
            $table->string('custom_class')->nullable();
            $table->integer('status')->default(1);
            $table->integer('weight')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_sliders_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description', 400)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_sliders_temp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sliderid');
            $table->string('template')->nullable();
            $table->string('theme');
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_sliders');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_sliders_group');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_sliders_temp');
    }
}
