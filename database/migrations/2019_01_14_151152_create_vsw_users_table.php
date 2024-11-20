<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_users', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('in_group')->default(0);
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('password')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->char('gender', 1)->default('N');
            $table->string('avatar')->nullable();
            $table->string('birthday')->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('skype')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('question')->nullable();
            $table->string('answer')->nullable();                        
            $table->string('about')->nullable();
            $table->tinyInteger('active')->default(0);
            $table->string('last_login')->nullable();
            $table->string('last_ip')->nullable();
            $table->string('locale')->default(config('app.locale'));
            $table->enum('online', ['1', '0'])->default(1);
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('vsw_users');
    }
}
