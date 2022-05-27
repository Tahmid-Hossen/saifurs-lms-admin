<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned()->nullable();
            $table->integer('item_id')->unsigned()->nullable()->comment('model primary_id');
            $table->string('item_path')->nullable()->comment('model full namespace path');
            $table->text('item_description')->nullable();
            $table->json('item_extra')->nullable();
            $table->string('delivery_type')->default('online');
            $table->double('price_amount', 18,2)->default(0);
            $table->double('quantity', 18, 4)->default(0);
            $table->double('sub_total_amount', 18, 2)->default(0);
            $table->double('discount_amount', 18, 2);
            $table->double('total_amount', 18, 2)->default(0);
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
}
