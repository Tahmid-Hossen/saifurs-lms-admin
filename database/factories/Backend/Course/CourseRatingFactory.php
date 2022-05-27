<?php

namespace Database\Factories\Backend\Course;

use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseRating;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseRatingFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseRating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $created_at = $this->faker->dateTimeThisYear;
        $updated_at = $this->faker->dateTimeBetween( $created_at, $created_at->format( 'Y-m-d H:i:s' ) . ' +90 days' );
        $courseIds = Course::all()->pluck( 'id' )->toArray();
        $courseId = $this->faker->randomElement( $courseIds );
        $companyId = Course::where( 'id', $courseId )->first()->company_id;
        return [
            'company_id'               => $companyId,
            'branch_id'                => $companyId,
            'course_id'                => $courseId,
            'user_id'                  => $this->faker->numberBetween( 11, 15 ),
            'course_rating_stars'      => $this->faker->numberBetween( 0, 5 ),
            'course_rating_feedback'   => $this->faker->realText( 30, 1 ),
            'is_approved'              => $this->faker->randomElement( ["YES", "NO"] ),
            'course_rating_status'     => $this->faker->randomElement( ["ACTIVE", "IN-ACTIVE"] ),
            'created_by'               => $this->faker->numberBetween( 11, 15 ),
            'updated_by'               => 1,
            'created_at'               => $created_at,
            'updated_at'               => $updated_at,
        ];
    }
}
