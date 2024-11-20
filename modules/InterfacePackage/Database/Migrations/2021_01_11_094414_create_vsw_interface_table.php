<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswInterfaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_interfacepackage', function (Blueprint $table) {
            $table->id();
            $table->integer('catid');
            $table->string('svp_code');
            $table->string('title');
            $table->string('slug');
            $table->string('description', 400)->nullable();
            $table->text('keyword')->nullable();
            $table->longText('content');
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->string('image', 255)->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_interface_catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parentid')->unsigned()->default(0)->index();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('description', 400)->nullable();
            $table->text('keyword')->nullable();
            $table->integer('lev')->nullable();
            $table->integer('weight')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_interface_sentiment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('interfaceid');
            $table->integer('userid');
            $table->string('sentiment');
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_interfacepackage');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_interface_catalogs');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_interface_sentiment');
    }
}
