<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CreateVswMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_menus_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->mediumText('menu_items')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parentid')->nullable();
            $table->mediumText('submenu')->nullable();
            $table->integer('groupid')->nullable();
            $table->string('title');
            $table->string('urltype');
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->string('module')->nullable();
            $table->string('route')->nullable();
            $table->string('icon')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('lev')->nullable();
            $table->integer('active')->nullable();
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_menus_group');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_menus');
    }
}
