<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('vendor_id')->unsigned()->nullable();
            $table->integer('course_id')->unsigned()->nullable();
            $table->integer('course_batch_id')->unsigned()->nullable();
            $table->integer('course_chapter_id')->unsigned()->nullable();
            $table->integer('course_class_id')->unsigned()->nullable();
            $table->integer('instructor_id')->unsigned()->nullable();
            $table->string('vendor_meeting_owner_id')->nullable()->comment('use for google meet');
            $table->string('vendor_meeting_title')->nullable();
            $table->string('vendor_meeting_type')->nullable();
            $table->longText('vendor_meeting_agenda')->nullable();
            $table->dateTime('vendor_meeting_start_time')->nullable();
            $table->dateTime('vendor_meeting_end_time')->nullable();
            $table->string('vendor_meeting_duration')->nullable();
            $table->string('vendor_meeting_timezone')->nullable();
            $table->string('vendor_meeting_link_by')->nullable();
            $table->string('vendor_meeting_url')->nullable();
            $table->string('vendor_meeting_logo')->nullable();
            $table->string('vendor_meeting_status')->nullable();

            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('course')->onDelete('cascade');
            $table->foreign('course_chapter_id')->references('id')->on('course_chapters')->onDelete('cascade');
            $table->foreign('course_class_id')->references('id')->on('course_classes')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_batch_id')->references('id')->on('course_batches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_meetings');
    }
}
