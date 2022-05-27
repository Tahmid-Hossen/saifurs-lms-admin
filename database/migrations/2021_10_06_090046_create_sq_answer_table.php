<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->index('uid');
            $table->integer('quid')->index('quid');
            $table->integer('rid')->index('rid');
            $table->integer('question_id');
            $table->text('user_response');
            $table->integer('response_time');
            $table->timestamp('created_time')->useCurrent();
            $table->integer('trash_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sq_answer');
    }
}
