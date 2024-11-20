<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CreateVswNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_news_catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parentid')->unsigned()->default(0)->index();
            $table->string('title');
            $table->string('description', 400)->nullable();
            $table->text('keyword')->nullable();
            $table->integer('lev')->nullable();
            $table->integer('weight')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_news_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description', 400)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_news_catpost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('catid');
            $table->integer('newid');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_news_grouppost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('groupid');
            $table->integer('newid');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('content');
            $table->string('description', 400)->nullable();
            $table->text('keyword')->nullable();
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->integer('user_id')->references('id')->on('vsw_users');
            $table->string('image', 255)->nullable();
            $table->integer('views')->default(0);
            $table->integer('numcat')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_news_catalogs');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_news_catpost');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_news_groups');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_news_grouppost');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_news');
    }
}
