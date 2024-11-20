<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CreateVswTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_testimonials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->mediumText('testimonial');
            $table->tinyInteger('active')->unsigned()->default(0);
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_testimonials');
    }
}
