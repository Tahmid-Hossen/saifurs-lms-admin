<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseRatingRepository;
use App\Support\Configs\Constants;
use Illuminate\Support\Facades\Auth;
use Exception;

class CourseRatingService {
    /**
     * @var CourseRatingRepository
     */
    private $courseRatingRepository;

    /**
     * UserDetailsService constructor.
     * @param CourseRatingRepository $courseRatingRepository
     */
    public function __construct( CourseRatingRepository $courseRatingRepository ) {
        $this->courseRatingRepository = $courseRatingRepository;
    }

    /**
     * @param $input
     * @return false|mixed
     * @throws Exception
     */
    public function createCourseRating($input ) {
        try {
            return $this->courseRatingRepository->create( $input );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return false|mixed
     * @throws Exception
     */
    public function updateCourseRating($input, $id ) {
        try {
            $userDetails = $this->courseRatingRepository->find( $id );
            $this->courseRatingRepository->update( $input, $id );
            return $userDetails;

        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseRating( $input ) {
        return $this->courseRatingRepository->filterData( $input );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showCourseRatingByID( $id ) {
        return $this->courseRatingRepository->find( $id );
    }

    /**
     * @param $input
     * @return bool|mixed
     * @throws Exception
     */
    public function courseRatingCustomInsert($input ) {
        $output['user_id'] = Auth::id();
        $output['company_id'] = $input['company_id'];
        $output['course_rating_stars'] = $input['course_rating_stars'];
        $output['course_rating_feedback'] = isset($input['course_rating_feedback'])?$input['course_rating_feedback']:null;
        $output['course_id'] = $input['course_id'];
        $output['is_approved'] = isset($input['is_approved'])?$input['is_approved']:'NO';
        $output['course_rating_status'] = isset($input['course_rating_status'])?$input['course_rating_status']:Constants::$user_active_status;
        return $this->createCourseRating( $output );
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     * @throws Exception
     */
    public function courseRatingCustomUpdate($input, $id ) {
        $output = $input;
        $output['user_id'] = Auth::id();
        $output['company_id'] = $input['company_id'];
        $output['course_rating_stars'] = $input['course_rating_stars'];
        $output['course_rating_feedback'] = isset($input['course_rating_feedback'])?$input['course_rating_feedback']:null;
        $output['course_id'] = $input['course_id'];
        $output['is_approved'] = isset($input['is_approved'])?$input['is_approved']:'NO';
        $output['course_rating_status'] = isset($input['course_rating_status'])?$input['course_rating_status']:Constants::$user_active_status;
        return $this->updateCourseRating( $output, $id );
    }
}
