<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('course_id')->nullable()->unsigned();
            $table->integer('course_chapter_id')->nullable()->unsigned();
            $table->integer('course_class_id')->nullable()->unsigned();
            $table->string('announcement_title')->nullable();
            $table->longText('announcement_details')->nullable();
            $table->string('announcement_type')->nullable()->default('general');
            $table->date('announcement_date')->nullable();
            $table->string('announcement_status')->nullable()->default('ACTIVE');
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('course')->onDelete('cascade');
            $table->foreign('course_chapter_id')->references('id')->on('course_chapters')->onDelete('cascade');
            $table->foreign('course_class_id')->references('id')->on('course_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
