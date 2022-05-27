<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('course_id')->unsigned()->nullable();
            $table->string('chapter_title');
            $table->longText('chapter_short_description')->nullable();
            $table->longText('chapter_description')->nullable();
            $table->string('chapter_slug')->nullable();
            $table->string('chapter_image')->nullable();
            $table->string('chapter_file')->nullable();
            $table->string('chapter_download_able')->default('No');
            $table->string('chapter_status')->nullable();
            $table->string('chapter_featured')->default('No');
            $table->integer('chapter_position')->nullable();
            $table->string('chapter_drip_content')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('course')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_chapters');
    }
}
