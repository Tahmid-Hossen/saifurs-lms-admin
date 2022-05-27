<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_classes', function (Blueprint $table) {
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
            $table->string('class_name');
            $table->enum( 'class_type', ['Online', 'Offline'] )->nullable()->default( 'Offline' ) ->comment("online => live class , offline => tutorials");
            $table->longText('class_requirements')->nullable();
            $table->longText('class_short_description')->nullable();
            $table->longText('class_description')->nullable();
            $table->string('class_slug')->nullable();
            $table->string('class_image')->nullable();
            $table->string('class_file')->nullable();
            $table->string( 'class_video' )->nullable();
            $table->string( 'class_video_url' )->nullable();
            $table->string('class_download_able')->default('No');
            $table->string('class_status')->nullable();
            $table->string('class_featured')->default('No');
            $table->integer('class_position')->nullable();
            $table->string('class_drip_content')->nullable();
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
        Schema::dropIfExists('course_classes');
    }
}
