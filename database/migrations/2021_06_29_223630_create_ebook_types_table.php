<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbookTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_types', function (Blueprint $table) {
            $table->increments('ebook_type_id');
            $table->string('ebook_type_name');
            $table->string('extension')->nullable();
            $table->string('content_type')->nullable();
            $table->string('ebook_type_description')->nullable();
            $table->string('ebook_status')->nullable()->default('ACTIVE');
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebook_types');
    }
}
