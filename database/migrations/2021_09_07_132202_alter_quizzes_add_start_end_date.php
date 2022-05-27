<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuizzesAddStartEndDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dateTime('quiz_start')->nullable()->after('quiz_status');
            $table->dateTime('quiz_end')->nullable()->after('quiz_start');
            $table->string('quiz_duration')->nullable()->after('quiz_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('quiz_start');
            $table->dropColumn('quiz_end');
            $table->dropColumn('quiz_duration');
        });
    }
}
