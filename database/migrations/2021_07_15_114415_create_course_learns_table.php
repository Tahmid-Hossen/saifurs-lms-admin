<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_learns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')
                    ->references('id')
                    ->on('course')
                    ->onDelete('cascade');
            $table->integer('course_chapter_id')->unsigned()->nullable();
            $table->foreign('course_chapter_id')
                    ->references('id')
                    ->on('course_chapters')
                    ->onDelete('cascade');
            $table->integer('class_id')->unsigned()->nullable();
            $table->foreign('class_id')
                    ->references('id')
                    ->on('course_classes')
                    ->onDelete('cascade');
            $table->string('learn_title')->nullable();
            $table->longText('learn_details')->nullable();
            $table->string('learn_file')->nullable();
            $table->string('learn_status')->nullable();
            $table->integer('learn_position')->nullable();
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
        Schema::dropIfExists('course_learns');
    }
}
