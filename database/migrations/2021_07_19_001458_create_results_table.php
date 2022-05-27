<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')
                ->references('id')
                ->on('course')
                ->onDelete('cascade');
            $table->integer('class_id')->unsigned()->nullable();
            $table->foreign('class_id')
                ->references('id')
                ->on('course_classes')
                ->onDelete('cascade');
            $table->integer('quiz_id')->unsigned()->nullable();
            $table->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')
                ->onDelete('cascade');
            $table->integer('batch_id')->unsigned()->nullable();
            $table->foreign('batch_id')
                ->references('id')
                ->on('course_batches')
                ->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->string('result_title')->nullable();
            $table->string('result_slug')->nullable();
            $table->string('quiz_type')->nullable();
            $table->longText('result_details')->nullable();
            $table->string('result_file')->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->decimal('pass_score', 5, 2)->nullable();
            $table->decimal('fail_score', 5, 2)->nullable();
            $table->string('result_status')->nullable();
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
        Schema::dropIfExists('results');
    }
}
