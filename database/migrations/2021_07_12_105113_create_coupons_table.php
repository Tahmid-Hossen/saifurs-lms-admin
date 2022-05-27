<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'coupons', function ( Blueprint $table ) {
            $table->increments('id');

            // Foreign Keys
            $table->integer( 'company_id' )->unsigned()->nullable();
            $table->foreign( 'company_id' )->references( 'id' )->on( 'companies' )->onDelete( 'cascade' );

            // Local Keys
            $table->string( 'coupon_title' )->nullable();
            $table->string( 'coupon_code' )->nullable();
            $table->dateTime( 'coupon_start' )->nullable();
            $table->dateTime( 'coupon_end' )->nullable();
            $table->enum('discount_type', ['fixed', 'percent'])->default('fixed');
            $table->double('discount_amount', 18, 3)->default(0);
            $table->string('effect_on')->default('sub_total');
            $table->string('remarks')->nullable();
            $table->string( 'coupon_status' )->nullable()->default( 'ACTIVE' );
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
        Schema::dropIfExists( 'coupons' );
    }
}
