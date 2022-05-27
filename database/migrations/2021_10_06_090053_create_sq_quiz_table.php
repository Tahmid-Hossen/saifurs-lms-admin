<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_quiz', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('course_id');
            $table->string('quiz_name', 256);
            $table->string('description', 256);
            $table->integer('start_datetime');
            $table->integer('end_datetime');
            $table->text('qids');
            $table->string('gids', 1000);
            $table->integer('max_attempt')->default(100);
            $table->float('min_pass_percentage');
            $table->float('correct_score')->default(1);
            $table->float('incorrect_score')->default(0);
            $table->integer('instant_result')->default(0);
            $table->integer('duration')->default(10);
            $table->integer('show_result')->default(1);
            $table->integer('show_result_on_date')->default(0);
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
        Schema::dropIfExists('sq_quiz');
    }
}
