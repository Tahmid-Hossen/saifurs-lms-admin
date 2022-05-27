<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('publisher')->after('edition')->nullable();
            $table->string('country')->after('language')->nullable();
            $table->longText('author_info')->after('author')->nullable();
            $table->text('file')->after('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('publisher');
            $table->dropColumn('country');
            $table->dropColumn('author_info');
            $table->dropColumn('file');
        });
    }
}
