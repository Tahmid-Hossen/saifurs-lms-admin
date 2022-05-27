<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('book_id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->string('book_name');
            $table->string('book_slug')->nullable();
            $table->string('edition')->nullable();
            $table->string('author')->nullable();
            $table->string('contributor')->nullable();
            $table->text('book_description')->nullable();
            $table->integer('book_category_id')->unsigned()->nullable();
            $table->string('language')->default(1)->comment('UtilityService::$languageList');
            $table->date('publish_date')->nullable();
            $table->string('isbn_number', 50);
            $table->longText('photo')->default('[]')->nullable();
            $table->integer('pages')->unsigned()->default(0);
            $table->string('is_sellable', 10)->default('NO')->comment('UtilityService::$featuredStatusText');
            $table->double('book_price', 18, 2)->nullable();
			$table->double('discount_price', 18, 2)->nullable();
			$table->double('special_price', 18, 2)->nullable();
			$table->integer('ragular_price_flag')->default(0);
			$table->integer('special_price_flag')->default(0);	
			$table->integer('quantity')->default(0);			
            $table->double('book_discount', 15, 2)->nullable();
            $table->string('currency', 10)->default('BDT')->comment('UtilityService::$currencyList');
            $table->string('is_ebook', 10)->default('NO')->comment('UtilityService::$featuredStatusText');
            $table->integer('ebook_type_id')->unsigned()->nullable();
            $table->string('storage_path')->nullable();
            $table->string('book_status')->nullable()->default('ACTIVE');
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->integer('deleted_by')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('ebook_type_id')->references('ebook_type_id')->on('ebook_types')->onDelete('cascade');
            $table->foreign('book_category_id')->references('book_category_id')
                ->on('book_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
