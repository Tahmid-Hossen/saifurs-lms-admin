<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');

            // Foreign Keys
            $table->integer( 'company_id' )->unsigned()->nullable();
            $table->foreign( 'company_id' )->references( 'id' )->on( 'companies' )->onDelete( 'cascade' );

            // Local Keys
            $table->string( 'banner_title' )->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_position')->nullable();
            $table->string('text_align')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('banner_status')->nullable()->default('ACTIVE');
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
        Schema::dropIfExists('banners');
    }
}
