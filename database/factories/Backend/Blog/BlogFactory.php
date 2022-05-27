<?php

namespace Database\Factories\Backend\Blog;

use App\Models\Backend\Blog\Blog;
use App\Models\Backend\User\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Storage;

class BlogFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $created_at = $this->faker->dateTimeThisYear;
        $publish = $this->faker->dateTimeThisYear;
        $updated_at = $this->faker->dateTimeBetween( $created_at, $created_at->format( 'Y-m-d H:i:s' ) . ' +20 days' );
        $companyIds = Company::all()->pluck( 'id' )->toArray();
        $user_Ids = User::all()->pluck( 'id' )->toArray();
        $companyId = $this->faker->randomElement( $companyIds );
        $user_Id = $this->faker->randomElement( $user_Ids );
        $image = $this->faker->image();
        $imageFile = new File($image);
        return [
            'company_id'        => $companyId,
            'user_id'           => $user_Id,
            'blog_title'      => $this->faker->catchPhrase,
            'blog_type'      => $this->faker->catchPhrase,
            'blog_description'      => $this->faker->text,
            'blog_publish_date'      => $publish,
            'blog_logo'      => Storage::disk('public')->putFile('/upload/images/blog_logo', $imageFile),
            'blog_status'     => $this->faker->randomElement( ["ACTIVE", "IN-ACTIVE"] ),
            'created_by'        => $this->faker->numberBetween( 1, 10 ),
            'updated_by'        => $this->faker->numberBetween( 1, 10 ),
            'created_at'        => $created_at,
            'updated_at'        => $updated_at
        ];
    }
}
