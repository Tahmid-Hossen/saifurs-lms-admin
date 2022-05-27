<?php

namespace Database\Factories\Backend\Course;

use App\Models\Backend\User\Company; 
use App\Models\Backend\Course\CourseCategory;
use App\Support\Configs\Constants;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $companyIds = Company::all()->pluck( 'id' )->toArray();
        // $companyId = $this->faker->randomElement( $companyIds );
        // $categoryTitle = 'Basic '.$this->faker->jobTitle.' Tutorial';
        // $categorySlug = Str::slug($categoryTitle);
        // $status = $this->faker->randomElement( Constants::$course_status );
        // $featured = $this->faker->randomElement( Constants::$course_featured );
        // return [
        //     'company_id' => $companyId,
        //     'course_category_title' => $categoryTitle,
        //     'course_category_slug' => $categorySlug,
        //     'course_category_details' => 'This is a Course Category to increase '.$categoryTitle.' related skill',
        //     'course_category_featured' => $featured,
        //     'course_category_status' => $status
        // ];

    }
}
