<?php

namespace Database\Factories\Backend\CourseManage;

use App\Models\Backend\Course\CourseClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => mt_rand(1, 4),
            'branch_id' => mt_rand(1,4),
            'course_category_id' => mt_rand(1,4),
            'course_sub_category_id' => mt_rand(1,4),
            'course_child_category_id' => mt_rand(1,4),
            'course_id' => mt_rand(1,4),
            'chapter_id' => mt_rand(1,4),
            'class_name' => ucwords($this->faker->words(5, true)),
            'class_requirements' => $this->faker->paragraph(),
            'class_short_description' => $this->faker->paragraph(),
            'class_description' => $this->faker->paragraph(),
            'class_status' => 'ACTIVE',
            'class_featured' => 'No',
            'class_image' => '/assets/img/book_default.jpg',
        ];
    }
}
