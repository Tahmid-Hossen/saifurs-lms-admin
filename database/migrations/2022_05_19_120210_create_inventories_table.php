<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('book_id', 11)->nullable();
            $table->string('initial_qty', 11)->nullable();
            $table->string('increment_qty', 11)->nullable();
            $table->string('decrement_qty', 11)->nullable();
            $table->string('current_qty', 11)->nullable();
            $table->string('initial_price', 11)->nullable();
            $table->string('purchase_price', 11)->nullable();
            $table->string('sell_price', 11)->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
