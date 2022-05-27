<?php

namespace Database\Factories\Backend\Books;

use App\Models\Backend\Books\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $max_category = \DB::table('book_categories')->max('book_category_id');

        $return = [
            'company_id' => mt_rand(1, 4),
            'book_name' => ucwords((string)$this->faker->words(5, true)),
            'edition' => mt_rand(3, 10) . 'th',
            'author' => $this->faker->name(),
            'contributor' => $this->faker->name(),
            'book_description' => $this->faker->paragraph(),
            'book_category_id' => mt_rand(1, $max_category),
            'language' => mt_rand(1, 2),
            'publish_date' => date('Y-m-d'),
            'isbn_number' => $this->faker->isbn13(),
            'photo' => '/assets/img/static/book.jpg',
            'pages' => mt_rand(10, 2500),
            'is_sellable' => ((mt_rand(1, 15) % 2 == 0) ? 'YES' : 'NO'),
            'currency' => 'BDT',
            'is_ebook' => ((mt_rand(1, 10) % 2 == 0) ? 'YES' : 'NO'),
            'book_status' => 'ACTIVE'
        ];

        switch ($return['company_id']) {
            case 1 :
                $return['branch_id'] = mt_rand(1, 2);
                break;
            case 2 :
                $return['branch_id'] = mt_rand(3, 5);
                break;
            case 3 :
                $return['branch_id'] = mt_rand(6, 8);
                break;
            case 4 :
                $return['branch_id'] = mt_rand(9, 11);
                break;
            default :
                $return['branch_id'] = 1;
                break;
        };

        $return['book_price'] = ($return['is_sellable'] == 'YES') ? mt_rand(10000, 90000) : null;
        $return['ebook_type_id'] = ($return['is_ebook'] == 'YES') ? mt_rand(1, 5) : null;
        $return['storage_path'] = ($return['is_ebook'] == 'YES') ? '/assets/dummy.pdf' : NULL;

        return $return;
    }
}
