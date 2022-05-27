<?php

namespace Database\Factories\Backend\Books;

use App\Models\Backend\Books\EBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class EBookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EBook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ebook_name' => ucwords($this->faker->words(5, true)),
            'edition' => mt_rand(3, 10) . 'th',
            'author' => $this->faker->name(),
            'contributor' => $this->faker->name(),
            'ebook_description' => $this->faker->paragraph(),
            'language' => mt_rand(1,2),
            'publish_date' => date("Y-m-d", mt_rand(1262055681,1262055681)),
            'isbn_number' => $this->faker->isbn13(),
            'ebook_status' => 'ACTIVE',
            'book_category_id' => mt_rand(1, 50),
            'ebook_type_id' => mt_rand(1,5),
            'company_id' => mt_rand(1, 4),
            'photo' => '/assets/img/book_default.jpg',
            'branch_id' => mt_rand(1,4),
            'storage_path' => '/assets/dummy.pdf',
            'size' => 287993
        ];
    }
}
