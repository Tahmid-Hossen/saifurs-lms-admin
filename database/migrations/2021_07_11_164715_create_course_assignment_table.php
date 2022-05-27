<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAssignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('student_id')->unsigned()->nullable();
            $table->integer('instructor_id')->unsigned()->nullable();
            $table->integer('course_id')->nullable()->unsigned();
            $table->integer('course_chapter_id')->nullable()->unsigned();
            $table->foreign('course_chapter_id')->references('id')->on('course_chapters')->onDelete('cascade');
            $table->integer('announcement_id')->nullable()->unsigned();
            $table->string('course_assignment_name')->nullable();
            $table->longText('course_assignment_detail')->nullable();
            $table->string('course_assignment_url')->nullable();
            $table->string('course_assignment_document')->nullable();
            $table->string('course_assignment_review')->nullable()->default('Unchecked');
            $table->string('course_assignment_score')->nullable();
            $table->string('course_assignment_status')->nullable();
            $table->string('course_assignment_review_by')->nullable();
            $table->string('course_assignment_review_at')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('course')->onDelete('cascade');
            $table->foreign('announcement_id')->references('id')->on('announcements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_assignments');
    }
}
