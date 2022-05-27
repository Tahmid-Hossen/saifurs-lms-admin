<?php

namespace Database\Seeders;

use App\Models\Backend\Books\Category;
use Illuminate\Database\Seeder;

class BookCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('book_categories')->insert(array(
            array('book_category_id' => '1','company_id' => '1','book_category_name' => 'BCS Analysis','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '0','deleted_by' => '0','created_at' => '2021-10-24 15:22:26','updated_at' => '2021-10-24 15:22:26','deleted_at' => NULL),
            array('book_category_id' => '2','company_id' => '1','book_category_name' => 'Private Bank','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '0','deleted_by' => '0','created_at' => '2021-10-24 15:27:34','updated_at' => '2021-10-24 15:27:34','deleted_at' => NULL),
            array('book_category_id' => '3','company_id' => '1','book_category_name' => 'Spoken English','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '0','deleted_by' => '0','created_at' => '2021-10-24 15:31:29','updated_at' => '2021-10-24 15:31:29','deleted_at' => NULL),
            array('book_category_id' => '4','company_id' => '1','book_category_name' => 'English Grammar','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '1','deleted_by' => '0','created_at' => '2021-10-24 15:42:00','updated_at' => '2021-10-24 16:03:10','deleted_at' => NULL),
            array('book_category_id' => '5','company_id' => '1','book_category_name' => 'IBA Admission','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '1','deleted_by' => '0','created_at' => '2021-10-24 15:43:51','updated_at' => '2021-10-24 15:52:17','deleted_at' => NULL),
            array('book_category_id' => '6','company_id' => '1','book_category_name' => 'MBA Admission','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '0','deleted_by' => '0','created_at' => '2021-10-24 15:48:02','updated_at' => '2021-10-24 15:48:02','deleted_at' => NULL),
            array('book_category_id' => '7','company_id' => '1','book_category_name' => 'Interview Preparation','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '1','deleted_by' => '0','created_at' => '2021-10-24 15:50:41','updated_at' => '2021-10-24 16:02:25','deleted_at' => NULL),
            array('book_category_id' => '8','company_id' => '1','book_category_name' => 'Phonetics','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '0','deleted_by' => '0','created_at' => '2021-10-24 15:51:47','updated_at' => '2021-10-24 15:51:47','deleted_at' => NULL),
            array('book_category_id' => '9','company_id' => '1','book_category_name' => 'সাইফুর’স প্রাক-প্রাথমিক সহকারী','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '1','deleted_by' => '0','created_at' => '2021-10-24 15:56:39','updated_at' => '2021-10-24 15:59:48','deleted_at' => NULL),
            array('book_category_id' => '10','company_id' => '1','book_category_name' => 'Government Bank','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '1','deleted_by' => '0','created_at' => '2021-10-24 15:57:50','updated_at' => '2021-10-24 16:00:20','deleted_at' => NULL),
            array('book_category_id' => '11','company_id' => '1','book_category_name' => 'প্রাথমিক সহকারী শিক্ষক নিয়োগ সহায়িকা','book_category_status' => 'ACTIVE','created_by' => '1','updated_by' => '0','deleted_by' => '0','created_at' => '2021-10-24 15:58:28','updated_at' => '2021-10-24 15:58:28','deleted_at' => NULL)
        ));
    }
}
