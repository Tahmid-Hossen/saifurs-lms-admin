<?php

namespace Database\Factories\Backend\Course;

use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseChildCategory;
use App\Support\Configs\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        // $courseChildCategoryIds = CourseChildCategory::all()->pluck( 'id' )->toArray();
        // $courseChildCategoryId = $this->faker->randomElement( $courseChildCategoryIds );
        // $companyId = CourseChildCategory::where('id',$courseChildCategoryId)->first()->company_id;
        // $courseCategoryId = CourseChildCategory::where('id',$courseChildCategoryId)->first()->course_category_id;
        // $courseSubCategoryId = CourseChildCategory::where('id',$courseChildCategoryId)->first()->course_sub_category_id;
        // $courseTitle = $this->faker->jobTitle.' Tutorial';
        // $courseSlug = Str::slug( $courseTitle );
        // $status = $this->faker->randomElement( Constants::$course_status );
        // $featured = $this->faker->randomElement( Constants::$course_featured );
        // $isAssignment = $this->faker->randomElement( Constants::$course_assignment );
        // $isCertified = $this->faker->randomElement( Constants::$course_assignment );
        // $isSubscribed = $this->faker->randomElement( Constants::$course_assignment );
        // $courseLanguage = $this->faker->randomElement( [Constants::$course_default_language, Constants::$course_ba_language, Constants::$course_us_language] );
        // $courseFileFormat = $this->faker->randomElement( [Constants::$course_pdf_format, Constants::$course_doc_format, Constants::$course_csv_format] );
        // $isDownloadable = $this->faker->randomElement( Constants::$course_assignment );
        // $drip_content = $this->faker->randomElement( Constants::$course_class_drip_content );
        // $courseContentType = $this->faker->randomElement( ['free', 'paid', 'promo'] );
        // $courseDuration = $this->faker->randomElement( ['Days', 'Weeks', 'Months'] );
        // $min = 0;
        // $max = 100;
        // $step = 0.5;
        // $courseDiscount = mt_rand( floor( $min / $step ), floor( $max / $step ) ) * $step;
        // $created_at = $this->faker->dateTimeThisYear;
        // $updated_at = $this->faker->dateTimeBetween( $created_at, $created_at->format( 'Y-m-d H:i:s' ) . ' +20 days' );
        // return [
        //     'course_category_id'       => $courseCategoryId,
        //     'course_sub_category_id'   => $courseSubCategoryId,
        //     'course_child_category_id' => $courseChildCategoryId,
        //     'company_id'               => $companyId,
        //     'course_title'             => $courseTitle,
        //     'course_slug'              => $courseSlug,
        //     'course_short_description' => $this->faker->realText( 50, 1 ),
        //     'course_duration'          => $courseDuration,
        //     'course_duration_expire'   => $this->faker->numberBetween( 1, 90 ),
        //     'course_is_assignment'     => $isAssignment,
        //     'course_is_certified'      => $isCertified,
        //     'course_is_subscribed'     => $isSubscribed,
        //     'course_featured'          => $featured,
        //     'course_status'            => $status,
        //     'course_language'          => $courseLanguage,
        //     'course_discount'          => $courseDiscount,
        //     'course_file_format'       => $courseFileFormat,
        //     'course_download_able'     => $isDownloadable,
        //     'course_drip_content'      => $drip_content,
        //     'course_content_type'      => $courseContentType,
        //     'created_by'               => $this->faker->numberBetween( 1, 10 ),
        //     'updated_by'               => $this->faker->numberBetween( 1, 10 ),
        //     'created_at'               => $created_at,
        //     'updated_at'               => $updated_at,
        // ];
    }
}
