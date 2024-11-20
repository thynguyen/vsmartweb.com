<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CreateVswPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('groupid')->nullable();
            $table->string('title', 50);
            $table->longText('description')->nullable();
            $table->text('keyword')->nullable();
            $table->integer('pagetype')->default(1);
            $table->string('image', 255)->nullable();
            $table->string('layout', 60)->nullable();
            $table->integer('views')->default(0);
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->integer('userid');
            $table->string('subdomain')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_pages_content', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pageid');
            $table->longText('content');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_pages_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description', 400)->nullable();
            $table->text('keyword')->nullable();
            $table->integer('weight')->default(0);
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_pages');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_pages_content');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_pages_groups');
    }
}
