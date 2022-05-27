<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCourseBatchesAddColums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_batches', function (Blueprint $table) {
            $table->date('course_batch_start_date')->after('course_batch_detail')->nullable();
            $table->date('course_batch_end_date')->after('course_batch_start_date')->nullable();
            $table->time('course_batch_student_limit')->after('course_batch_end_date')->nullable();
            $table->string('batch_class_days')->after('course_batch_student_limit')->nullable();
            $table->time('batch_class_start_time')->after('batch_class_days')->nullable();
            $table->time('batch_class_end_time')->after('batch_class_start_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_batches', function (Blueprint $table) {
            $table->dropColumn('course_batch_start_date');
            $table->dropColumn('course_batch_end_date');
            $table->dropColumn('batch_class_start_time');
            $table->dropColumn('batch_class_end_time');
            $table->dropColumn('course_batch_student_limit');
        });

    }
}
