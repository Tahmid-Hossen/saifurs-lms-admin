<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'quizzes', function ( Blueprint $table ) {
            $table->increments('id');

            // Foreign Keys
            $table->integer( 'company_id' )->unsigned()->nullable();
            $table->foreign( 'company_id' )->references( 'id' )->on( 'companies' )->onDelete( 'cascade' );
            $table->integer( 'branch_id' )->unsigned()->nullable();
            $table->foreign( 'branch_id' )->references( 'id' )->on( 'branches' )->onDelete( 'cascade' );
            $table->string( 'course_id' )->nullable();
            $table->string( 'drip_content')->nullable();
            $table->date( 'visible_date' )->nullable(); // if course drip content date selected
            $table->integer( 'visible_days' )->nullable(); // if course drip content day selected
            $table->string( 'quiz_type' )->default( 'objective' );
            $table->string( 'quiz_topic' )->nullable();
            $table->integer( 'quiz_full_marks' )->nullable();
            $table->double( 'quiz_pass_percentage' )->default( 33 );
            $table->string( 'quiz_description' )->nullable();
            $table->string( 'quiz_re_attempt')->default( 'IN-ACTIVE' );
            $table->longText('quiz_url')->nullable();
            $table->string( 'quiz_status')->default( 'ACTIVE' );
            $table->integer( 'deleted_by' )->unsigned()->default( 0 );
            $table->integer( 'created_by' )->unsigned()->default( 0 );
            $table->integer( 'updated_by' )->unsigned()->default( 0 );
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'quizzes' );
    }
}
