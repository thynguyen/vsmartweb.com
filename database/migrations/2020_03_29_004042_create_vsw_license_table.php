<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVswLicenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_license', function (Blueprint $table) {
            $table->id();
            $table->string('license');
            $table->string('domain')->nullable();
            $table->string('ip')->nullable();
            $table->string('status')->default('not activated');//not activated,activated,suspend,pending
            $table->string('message')->nullable();
            $table->timestamp('start_day')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('vsw_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->text('changelog')->nullable();
            $table->tinyInteger('current')->unsigned()->default(0);//Current
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
        Schema::dropIfExists('vsw_license');
        Schema::dropIfExists('vsw_versions');
    }
}
