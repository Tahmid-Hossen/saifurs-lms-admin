<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookRatingCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_rating_comments', function (Blueprint $table) {
            $table->increments('id');
            // Foreign Keys
            $table->integer( 'book_id' )->unsigned()->nullable();
            $table->foreign( 'book_id' )->references( 'book_id' )->on( 'books' )->onDelete( 'cascade' );
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Local Keys
            $table->string( 'book_rating' )->nullable();
            $table->text( 'book_comment' )->nullable();
            $table->string( 'is_approved' )->nullable()->default('NO');
            $table->string('book_rating_comment_status')->nullable()->default('ACTIVE');
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
        Schema::dropIfExists('book_rating_comments');
    }
}
