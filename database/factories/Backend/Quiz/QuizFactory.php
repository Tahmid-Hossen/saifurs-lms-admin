<?php

namespace Database\Factories\Backend\Quiz;

use App\Models\Backend\Course\Course;
use App\Models\Backend\Quiz\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $created_at = $this->faker->dateTimeThisYear;
        $updated_at = $this->faker->dateTimeBetween( $created_at, $created_at->format( 'Y-m-d H:i:s' ) . ' +20 days' );
        $courseIds = Course::all()->pluck( 'id' )->toArray();
        $courseId = $this->faker->randomElement( $courseIds );

        $companyId = Course::where('id',$courseId)->first()->company_id;
        $courseCategoryId = Course::where('id',$courseId)->first()->course_category_id;
        $courseSubCategoryId = Course::where('id',$courseId)->first()->course_sub_category_id;
        $courseChildCategoryId = Course::where('id',$courseId)->first()->course_child_category_id;
        $bool = Course::where('id',$courseId)->first()->course_drip_content;
        $drip_content = $days = $date = null;
        if ( $bool == 'Enable' ) {
            $drip_content = $this->faker->randomElement( ['specific_date', 'days_after_enrollment'] );
            if ( $drip_content == 'specific_date' ) {
                $days = null;
                $date = $this->faker->dateTimeThisYear;
            }
            if ( $drip_content == 'days_after_enrollment' ) {
                $days = $this->faker->numberBetween( 1, 365 );
                $date = null;
            }
        }

        return [
            'company_id'               => $companyId,
            'course_id'                => $courseId,
            'branch_id'                 => null,
            'drip_content'             => $drip_content,
            'visible_date'             => $date,
            'visible_days'             => $days,
            'quiz_type'                => $this->faker->randomElement( ["subjective", "objective"] ),
            'quiz_url'                 => $this->faker->url,
            'quiz_topic'               => $this->faker->catchPhrase,
            'quiz_full_marks'          => 10 * $this->faker->numberBetween( 1, 20 ),
            'quiz_pass_percentage'     => $this->faker->randomFloat( 2, 20, 80 ),
            'quiz_description'         => $this->faker->realText( 50, 1 ),
            'quiz_re_attempt'          => $this->faker->randomElement( ['YES', 'NO'] ),
            'quiz_status'              => $this->faker->randomElement( ['IN-ACTIVE', 'ACTIVE'] ),
            'created_by'               => $this->faker->numberBetween( 1, 10 ),
            'updated_by'               => $this->faker->numberBetween( 1, 10 ),
            'created_at'               => $created_at,
            'updated_at'               => $updated_at,
        ];
    }
}
