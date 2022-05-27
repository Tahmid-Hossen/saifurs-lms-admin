<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')
                    ->references('id')
                    ->on('companies')
                    ->onDelete('cascade');
            $table->integer('branch_id')->unsigned()->nullable();
            $table->foreign('branch_id')
                            ->references('id')
                            ->on('branches')
                            ->onDelete('cascade');
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')
                    ->references('id')
                    ->on('course')
                    ->onDelete('cascade');
            $table->integer('chapter_id')->unsigned()->nullable();
            $table->foreign('chapter_id')
                            ->references('id')
                            ->on('course_chapters')
                            ->onDelete('cascade');
            $table->integer('class_id')->unsigned()->nullable();
            $table->foreign('class_id')
                            ->references('id')
                            ->on('course_classes')
                            ->onDelete('cascade');
            $table->string('question_number')->unique()->nullable();
            $table->text('question')->nullable();
            $table->string('question_slug')->nullable();
            $table->string('question_image')->nullable();
            $table->string('question_status')->nullable();
            $table->integer('question_position')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_questions');
    }
}
