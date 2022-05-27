<?php

namespace Database\Factories\Backend\Announcement;

use App\Models\Backend\Announcement\Announcement;
use App\Models\Backend\Course\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcement::class;

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
        $companyId = Course::where( 'id', $courseId )->first()->company_id;

        $random = $this->faker->randomHtml( 3, 20 );
        $str1 = preg_replace( ['/<head>(.+)<\/head>/imu', '/<body>(.+)<\/body>/imu'], ['', '$1'], $random );
        $str2 = preg_replace( '/<html>(.+)<\/html>/imu', '$1', $str1 );
        $str3 = preg_replace( '/<form (.+)T">/imu', '<form>', $str2 );
        $announcement_details = preg_replace( ['/<form>(.+)<\/form>/imu', '/div/imu', '/h1/imu', '/h2/imu', '/h3/imu'], ['', 'span', 'h4', 'h4', 'h4'], $str3 );

        return [
            'company_id'           => $companyId,
            'course_id'            => $courseId,
            'announcement_title'   => $this->faker->catchPhrase,
            'announcement_details' => $announcement_details,
            'announcement_status'  => $this->faker->randomElement( ["ACTIVE", "IN-ACTIVE"] ),
            'created_by'           => $this->faker->numberBetween( 1, 15 ),
            'updated_by'           => $this->faker->numberBetween( 1, 15 ),
            'created_at'           => $created_at,
            'updated_at'           => $updated_at,
        ];
    }
}
