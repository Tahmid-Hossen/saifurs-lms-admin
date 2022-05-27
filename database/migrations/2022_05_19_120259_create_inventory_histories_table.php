<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->id();
            $table->string('book_id', 11)->nullable();
            $table->string('qty', 11)->nullable();
            $table->string('purchase_price', 11)->nullable();
            $table->string('sell_price', 11)->nullable();
            $table->string('remark', 11)->nullable();
            $table->string('stock_action', 11)->nullable();
            $table->string('vendor_name', 11)->nullable();
            $table->string('vendor_contact', 11)->nullable();
            $table->string('vendor_address', 11)->nullable();
            $table->string('date', 20)->nullable();
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
        Schema::dropIfExists('inventory_histories');
    }
}
