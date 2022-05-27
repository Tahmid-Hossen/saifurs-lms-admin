<?php

namespace Database\Factories\Backend\Course;

use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\Course\CourseSubCategory;
use App\Support\Configs\Constants;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseSubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseSubCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $courseCategoryIds = CourseCategory::all()->pluck( 'id' )->toArray();
        // $courseCategoryId = $this->faker->randomElement( $courseCategoryIds );
        // $companyId = CourseCategory::where('id',$courseCategoryId)->first()->company_id;
        // $subCategoryTitle = 'Advance '.$this->faker->jobTitle.' Tutorial';
        // $subCategorySlug = Str::slug($subCategoryTitle);
        // $status = $this->faker->randomElement( Constants::$course_status );
        // $featured = $this->faker->randomElement( Constants::$course_featured );
        // return [
        //     'course_category_id' => $courseCategoryId,
        //     'company_id' => $companyId,
        //     'course_sub_category_title' => $subCategoryTitle,
        //     'course_sub_category_slug' => $subCategorySlug,
        //     'course_sub_category_details' => 'This is a Course Sub Category to increase '.$subCategoryTitle.' related skill',
        //     'course_sub_category_featured' => $featured,
        //     'course_sub_category_status' => $status,
        // ];
    }
}
