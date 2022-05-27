<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_iso')->nullable();
            $table->string('country_name');
            $table->string('country_iso3')->nullable();
            $table->string('country_num_code')->nullable();
            $table->string('country_phone_code')->nullable();
            $table->string('country_currency')->nullable();
            $table->string('country_currency_symbol')->nullable();
            $table->string('country_language')->nullable();
            $table->string('country_logo')->nullable();
            $table->string('country_status')->nullable()->default('ACTIVE');
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
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
		Schema::drop('countries');
	}

}
