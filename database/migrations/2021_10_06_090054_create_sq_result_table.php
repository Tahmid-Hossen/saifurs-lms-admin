<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quid')->index('quid');
            $table->integer('uid')->index('uid');
            $table->integer('attempted_datetime');
            $table->text('assigned_qids');
            $table->text('qids_status');
            $table->text('ind_score');
            $table->text('attempted_questions');
            $table->float('time_spent');
            $table->text('ind_time');
            $table->string('result_status', 256)->default('Open');
            $table->integer('last_ping')->default(0);
            $table->integer('result_generated_time')->default(0);
            $table->float('obtained_score')->default(0);
            $table->float('obtained_percentage')->default(0);
            $table->string('result_generated_by', 100)->default('Not Generated');
            $table->integer('response_time');
            $table->text('color_codes');
            $table->integer('trash_status')->default(0);
            $table->timestamp('created_time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sq_result');
    }
}
