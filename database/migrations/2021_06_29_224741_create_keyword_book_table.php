<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyword_book', function (Blueprint $table) {
            $table->integer('keyword_id')->unsigned();
            $table->integer('book_id')->unsigned();
            $table->foreign('book_id')->references('book_id')->on('books')->onDelete('cascade');
            $table->foreign('keyword_id')->references('keyword_id')->on('keywords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyword_book');
    }
}
