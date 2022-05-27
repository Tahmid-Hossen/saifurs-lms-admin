<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookCategoriesAddedCompanyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->integer('company_id')->unsigned()->nullable()->after('book_category_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->dropForeign('book_categories_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}
