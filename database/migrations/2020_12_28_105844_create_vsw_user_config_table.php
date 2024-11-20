<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVswUserConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('vsw_user_config', function (Blueprint $table) {
            $table->integer('userid');
            $table->string('config_name',30);
            $table->text('config_value')->nullable();
            $table->string('config_token', 100)->nullable();
            $table->unique(['config_token']);
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
        Schema::dropIfExists('vsw_user_config');
    }
}
