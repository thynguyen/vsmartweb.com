<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVswWidgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsw_widget', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('widgetgroup');
            $table->string('widgetname');
            $table->string('position');
            $table->string('coverwidget');
            $table->string('theme');
            $table->string('groupview')->nullable();
            $table->integer('async')->default(1);
            $table->text('configwidget')->nullable();
            $table->string('locale');
            $table->string('custom_id')->nullable();
            $table->string('custom_class')->nullable();
            $table->integer('weight')->nullable();
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
        Schema::dropIfExists('vsw_widget');
    }
}
