<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_config', function (Blueprint $table) {
            $table->char('lang', 3);
            $table->string('module',25);
            $table->string('config_name',30);
            $table->text('config_value')->nullable();
            $table->unique(['lang', 'module','config_name']);
            $table->engine = 'InnoDB';
        });
    }
    // run command "php artisan migrate:refresh && php artisan db:seed"
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vsw_config');
    }
}
