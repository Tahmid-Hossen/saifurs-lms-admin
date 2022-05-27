<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->integer('quiz_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('total_mark')->nullable();
            $table->integer('achive_mark')->nullable();
            $table->integer('total_time')->nullable();
            $table->integer('spent_time')->nullable();
            $table->string('result_status', 11)->nullable();
            $table->string('created_by', 11)->nullable();
            $table->string('updated_by', 11)->nullable();
            $table->string('deleted_by', 11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_results');
    }
}
