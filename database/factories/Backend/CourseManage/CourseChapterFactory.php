<?php

namespace Database\Factories\Backend\CourseManage;

use App\Models\Backend\Course\CourseChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseChapter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    // public function definition()
    // {
    //     return [
    //         'company_id' => mt_rand(1, 4),
    //         'branch_id' => mt_rand(1,4),
    //         'course_category_id' => mt_rand(1,4),
    //         'course_sub_category_id' => mt_rand(1,4),
    //         'course_child_category_id' => mt_rand(1,4),
    //         'course_id' => mt_rand(1,4),
    //         'chapter_title' => ucwords($this->faker->words(5, true)),
    //         'chapter_requirements' => $this->faker->paragraph(),
    //         'chapter_short_description' => $this->faker->paragraph(),
    //         'chapter_description' => $this->faker->paragraph(),
    //         'chapter_status' => 'ACTIVE',
    //         'chapter_featured' => 'No',
    //         'chapter_image' => '/assets/img/book_default.jpg',
    //     ];
    // }

    public function definition()
    {
        return [
            'company_id' => $this->faker->unique()->company_id(),
            'branch_id' => $this->faker->unique()->branch_id(),
            'course_category_id' => $this->faker->unique()->course_category_id(),
            'course_sub_category_id' => $this->faker->unique()->course_sub_category_id(),
            'course_child_category_id' => $this->faker->unique()->course_child_category_id(),
            'course_id' => $this->faker->unique()->course_id(),
            'chapter_title' => $this->faker->unique()->chapter_title(),
            'chapter_requirements' => $this->faker->unique()->chapter_requirements(),
            'chapter_short_description' => $this->faker->chapter_short_description(),
            'chapter_description' => $this->faker->chapter_description(),
            'chapter_image' => $this->faker->chapter_image(),
            'chapter_status' => $this->faker->chapter_status(),
            'chapter_featured' => $this->faker->chapter_featured(),
        ];
    }

}
