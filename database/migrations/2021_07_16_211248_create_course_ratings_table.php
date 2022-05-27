<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_ratings', function (Blueprint $table) {
            $table->increments('id');

            // Foreign Keys
            $table->integer( 'user_id' )->unsigned()->nullable();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
            $table->integer( 'company_id' )->unsigned()->nullable();
            $table->foreign( 'company_id' )->references( 'id' )->on( 'companies' )->onDelete( 'cascade' );
            $table->integer( 'branch_id' )->unsigned()->nullable();
            $table->foreign( 'branch_id' )->references( 'id' )->on( 'branches' )->onDelete( 'cascade' );
            $table->integer( 'course_id' )->nullable()->unsigned();
            $table->foreign( 'course_id' )->references( 'id' )->on( 'course' )->onDelete( 'cascade' );

            // Local Keys
            $table->string( 'course_rating_stars' )->nullable();
            $table->longText( 'course_rating_feedback' )->nullable();
            $table->string( 'is_approved' )->nullable()->default('YES');
            $table->string('course_rating_status')->nullable()->default('ACTIVE');
            $table->integer( 'deleted_by' )->unsigned()->default( 0 );
            $table->integer( 'created_by' )->unsigned()->default( 0 );
            $table->integer( 'updated_by' )->unsigned()->default( 0 );
            $table->softDeletes();
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
        Schema::dropIfExists('course_ratings');
    }
}
