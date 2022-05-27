<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('log_time');
            $table->string('log_event', 1000);
            $table->integer('rid')->index('rid');
            $table->integer('uid')->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sq_logs');
    }
}
