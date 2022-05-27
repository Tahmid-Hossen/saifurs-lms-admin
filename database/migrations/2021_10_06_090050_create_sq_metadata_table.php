<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('meta_type', 256)->index('meta_type');
            $table->string('meta_name', 256);
            $table->text('meta_value');
            $table->integer('ref_id');
            $table->integer('trash_status')->default(0);
            $table->timestamp('created_time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sq_metadata');
    }
}
