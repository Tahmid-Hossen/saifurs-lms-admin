<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('course_category_id')->unsigned();
            $table->integer('course_sub_category_id')->unsigned();
            $table->integer('course_child_category_id')->unsigned();
            $table->string('course_title')->nullable();
            $table->longText('course_requirements')->nullable();
            $table->longText('course_short_description')->nullable();
            $table->longText('course_description')->nullable();
            $table->string('course_slug')->nullable();
            $table->string('course_seo_title')->nullable();
            $table->enum('course_content_type', ['free', 'paid', 'promo'])->default('free')->nullable();
            $table->string('course_image')->nullable();
            $table->enum('course_duration', ['Days', 'Weeks', 'Months'])->nullable()->default('Days');
            $table->integer('total_class_no')->nullable();
            $table->integer('course_duration_expire')->nullable()->unsigned();
            $table->string('course_video')->nullable();
            $table->string('course_video_url')->nullable();
            $table->string('course_drip_content')->nullable()->default('Enable');
            $table->string('course_is_assignment')->default('No');
            $table->string('course_is_certified')->default('No');
            $table->string('course_is_subscribed')->default('No');
            $table->string('course_status')->nullable();
            $table->string('course_language')->nullable();
            $table->double('course_regular_price', 15, 2)->nullable();
            $table->tinyInteger('involvement_request')->nullable()->default(0);
            $table->double('course_discount', 10, 2)->nullable();
            $table->string('course_file')->nullable();
            $table->string('course_download_able')->default('No');
            $table->string('course_featured')->default('No');
            $table->integer('course_position')->nullable();
            $table->integer('created_by')->nullable()->default(0);
            $table->integer('updated_by')->nullable()->default(0);
            $table->integer('deleted_by')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('course_category_id')->references('id')->on('course_category')->onDelete('cascade');
            $table->foreign('course_sub_category_id')->references('id')->on('course_sub_category')->onDelete('cascade');
            $table->foreign('course_child_category_id')->references('id')->on('course_child_category')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course');
    }
}
