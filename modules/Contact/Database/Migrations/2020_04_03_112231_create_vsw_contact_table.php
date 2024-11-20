<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVswContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_contact', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('customerid');
            $table->integer('partid')->nullable();
            $table->longText('messenger');
            $table->string('ip');
            $table->tinyInteger('read')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vsw_'.app()->getLocale().'_contact_customer', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('mobile')->nullable();
            $table->string('email');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vsw_'.app()->getLocale().'_contact_reply', function (Blueprint $table) {
            $table->id();
            $table->integer('authid');
            $table->integer('contactid');
            $table->longText('messenger');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vsw_'.app()->getLocale().'_contact_parts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vsw_'.app()->getLocale().'_contact_parts_email', function (Blueprint $table) {
            $table->id();
            $table->integer('partid');
            $table->integer('userid');
            $table->tinyInteger('sendemail')->default(0);
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_contact');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_contact_customer');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_contact_reply');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_contact_parts');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_contact_parts_email');
    }
}
