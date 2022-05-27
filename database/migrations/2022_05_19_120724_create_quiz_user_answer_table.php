<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizUserAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_user_answer', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->integer('quiz_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->integer('answer')->nullable();
            $table->integer('corect_answer')->nullable();
            $table->string('status')->nullable();
            $table->integer('score')->nullable();
            $table->integer('optained_score')->nullable();
            $table->string('created_by', 11)->nullable();
            $table->string('updated_by', 11)->nullable();
            $table->string('deleted_by', 11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_user_answer');
    }
}
