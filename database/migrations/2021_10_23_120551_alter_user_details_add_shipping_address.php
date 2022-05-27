<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserDetailsAddShippingAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->text('shipping_address')->after('state_id')->nullable();
            $table->string('shipping_post_code')->nullable()->after('shipping_address');
            $table->integer('shipping_city_id')->unsigned()->nullable()->after('shipping_post_code');
            $table->foreign('shipping_city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('shipping_state_id')->unsigned()->nullable()->after('shipping_city_id');
            $table->foreign('shipping_state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('shipping_address');
            $table->dropColumn('shipping_post_code');
            $table->dropForeign('user_details_shipping_city_id_foreign');
            $table->dropColumn('shipping_city_id');
            $table->dropForeign('user_details_shipping_state_id_foreign');
            $table->dropColumn('shipping_state_id');
        });
    }
}
