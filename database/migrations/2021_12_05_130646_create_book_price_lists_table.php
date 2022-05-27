<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('book_name')->nullable();
            $table->double('cover_price', 15, 2)->nullable();
            $table->double('retail_price', 15, 2)->nullable();
            $table->double('wholesale', 15, 2)->nullable();
            $table->string('status')->nullable()->default('ACTIVE');
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
        Schema::dropIfExists('book_price_lists');
    }
}
