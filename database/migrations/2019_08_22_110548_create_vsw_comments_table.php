<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->text('comment');
            $table->tinyInteger('vote')->nullable();
            $table->string('module');
            $table->string('locale');
            $table->tinyInteger('active')->unsigned()->default(1);
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
        Schema::dropIfExists('vsw_comments');
    }
}
