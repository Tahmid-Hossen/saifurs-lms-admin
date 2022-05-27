<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSqCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sq_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 256);
            $table->integer('parent_id');
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
        Schema::dropIfExists('sq_category');
    }
}
