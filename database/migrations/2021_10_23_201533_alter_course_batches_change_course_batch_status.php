<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCourseBatchesChangeCourseBatchStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_batches', function (Blueprint $table) {
            $table->dropColumn('course_batch_status');
        });

        Schema::table('course_batches', function (Blueprint $table) {
            $table->string('course_batch_status')->nullable()->default('ACTIVE')->after('course_batch_logo');
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
            $table->dropColumn('course_batch_status');
        });

        Schema::table('course_batches', function (Blueprint $table) {
            $table->string('course_batch_status')->nullable()->after('course_batch_logo');
        });
    }
}
