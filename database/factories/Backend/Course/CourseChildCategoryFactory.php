<?php

namespace Database\Factories\Backend\Course;

use App\Models\Backend\Course\CourseSubCategory;
use App\Models\Backend\Course\CourseChildCategory;
use App\Support\Configs\Constants;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseChildCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseChildCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $courseSubCategoryIds = CourseSubCategory::all()->pluck( 'id' )->toArray();
        // $courseSubCategoryId = $this->faker->randomElement( $courseSubCategoryIds );
        // $companyId = CourseSubCategory::where('id',$courseSubCategoryId)->first()->company_id;
        // $courseCategoryId = CourseSubCategory::where('id',$courseSubCategoryId)->first()->course_category_id;
        // $childCategoryTitle = 'Expert '.$this->faker->jobTitle.' Tutorial';
        // $childCategorySlug = Str::slug($childCategoryTitle);
        // $status = $this->faker->randomElement( Constants::$course_status );
        // $featured = $this->faker->randomElement( Constants::$course_featured );
        // return [
        //     'course_category_id' => $courseCategoryId,
        //     'course_sub_category_id' => $courseSubCategoryId,
        //     'company_id' => $companyId,
        //     'course_child_category_title' => $childCategoryTitle,
        //     'course_child_category_slug' => $childCategorySlug,
        //     'course_child_category_details' => 'This is a Course Sub Category to increase '.$childCategoryTitle.' related skill',
        //     'course_child_category_featured' => $featured,
        //     'course_child_category_status' => $status
        // ];
    }
}
