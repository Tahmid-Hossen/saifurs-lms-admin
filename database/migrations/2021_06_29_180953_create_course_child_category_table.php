<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseChildCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_child_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('course_category_id')->unsigned();
            $table->integer('course_sub_category_id')->unsigned();
            $table->string('course_child_category_title')->nullable();
            $table->string('course_child_category_slug')->nullable();
            $table->longText('course_child_category_details')->nullable();
            $table->string('course_child_category_image')->nullable();
            $table->string('course_child_category_status')->nullable();
            $table->string('course_child_category_featured')->default('No');
            $table->integer('course_child_category_position')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('course_category_id')->references('id')->on('course_category')->onDelete('cascade');
            $table->foreign('course_sub_category_id')->references('id')->on('course_sub_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_child_category');
    }
}
