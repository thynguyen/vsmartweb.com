<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CreateVswServicepackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_'.app()->getLocale().'_servicepack', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description', 400)->nullable();
            $table->text('listoption')->nullable();
            $table->string('icon')->nullable();
            $table->string('code');
            $table->decimal('price', 15, 0)->default(0);
            $table->decimal('price_sale', 15, 0)->default(0);
            $table->integer('discounts')->default(0);
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->integer('popular')->nullable()->default(0);
            $table->integer('contact')->nullable()->default(0);
            $table->integer('weight')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vsw_'.app()->getLocale().'_servicepack_reg', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->string('svp_code');
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_'.app()->getLocale().'_servicepack_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(0);
            $table->integer('userid');
            $table->string('svp_code');
            $table->decimal('price', 15, 0)->default(0);
            $table->text('note')->nullable();
            $table->string('transpay_code')->nullable();
            $table->string('trans_code')->nullable();
            $table->string('trans_ip', 100)->nullable();
            $table->integer('timeout')->nullable()->default(0);
            $table->tinyInteger('readtrans')->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        Schema::create('vsw_'.app()->getLocale().'_servicepack_translog', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(0);
            $table->integer('transid');
            $table->text('note')->nullable();
            $table->string('handler')->nullable();
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
        Schema::dropIfExists('vsw_'.app()->getLocale().'_servicepack');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_servicepack_reg');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_servicepack_transaction');
        Schema::dropIfExists('vsw_'.app()->getLocale().'_servicepack_translog');
    }
}
