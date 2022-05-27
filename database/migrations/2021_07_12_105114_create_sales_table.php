<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('customer id from users table')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->string('reference_number')->nullable();
            $table->integer('coupon_id')->nullable()->unsigned();
            $table->datetime('entry_date');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('ship_address')->nullable();
            $table->text('notes')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('transaction_response')->nullable();
            $table->string('currency')->nullable()->default('BDT');
            $table->double('sub_total_amount', 18, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percent'] )->default('percent');
            $table->double('discount_amount', 18, 2)->default(0);
            $table->double('shipping_cost', 18, 2)->default(0);
            $table->double('total_amount', 18, 2)->default(0);
            $table->double('online_total_amount', 18, 2)->default(0);
            $table->double('cod_total_amount', 18, 2)->default(0);
            $table->datetime('due_date')->nullable();
            $table->double('due_amount', 18, 2)->default(0);
            $table->enum('payment_status', ['partial', 'paid', 'unpaid', 'refunded'] )->default('unpaid');
            $table->enum('sale_status', ['pending', 'processing', 'completed', 'canceled', 'refunded', 'temporary'])->default('pending');
            $table->enum('source_type', ['web', 'app', 'office'])->default('office');
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sales');
        Schema::enableForeignKeyConstraints();
    }
}
