<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_question', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question_type', 256);
            $table->text('question');
            $table->text('description');
            $table->integer('category_ids');
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
        Schema::dropIfExists('sq_question');
    }
}
