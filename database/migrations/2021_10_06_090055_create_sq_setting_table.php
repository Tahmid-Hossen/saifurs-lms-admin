<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label_name', 1000);
            $table->string('setting_name', 1000);
            $table->text('setting_value');
            $table->integer('order_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sq_setting');
    }
}
