<?php

use App\Support\Configs\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('states')){
			Schema::create('states', function(Blueprint $table)
			{
                $table->increments('id');
                $table->integer('country_id')->nullable()->unsigned()->default(null);
                $table->string('state_name');
                $table->string('state_status')->nullable()->default(Constants::$user_active_status);
                $table->integer('deleted_by')->unsigned()->default(0);
                $table->integer('created_by')->unsigned()->default(0);
                $table->integer('updated_by')->unsigned()->default(0);
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('states');
	}

}
