<?php

namespace App\Repositories\Backend\CourseManage;

use App\Models\Backend\Course\CourseRating;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class CourseRatingRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model() {
        return CourseRating::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function filterData( $filters ): Builder {
        $query = $this->model->sortable()->newQuery();

        $query->join( 'companies', 'course_ratings.company_id', '=', 'companies.id' );
        // $query->join( 'branches', 'course_ratings.branch_id', '=', 'branches.id' ); // will need it in future
        $query->join( 'course', 'course_ratings.course_id', '=', 'course.id' );
        $query->leftJoin('users', 'users.id', '=', 'course_ratings.user_id');
        $query->leftJoin('user_details', 'users.id', '=', 'user_details.user_id');

        if ( !empty( $filters ) ) {
            // Course Rating ID
            if ( !empty( $filters['course_rating_id'] ) ) {
                $query->where( 'course_ratings.id', '=', $filters['course_rating_id'] );
            }

            // Course Rating Stars
            if ( !empty( $filters['course_rating_stars'] ) ) {
                $query->where( 'course_ratings.course_rating_stars', '=', ($filters['course_rating_stars']-1));
            }

            // Course Rating Stars
            if ( !empty( $filters['course_rating_stars'] ) ) {
                $query->where( 'course_ratings.course_rating_stars', '=', ($filters['course_rating_stars']-1));
            }

            // Course Rating Stars
            if ( !empty( $filters['is_approved'] ) ) {
                $query->where( 'course_ratings.is_approved', '=', $filters['is_approved']);
            }

            // Course Rating Status
            if ( !empty( $filters['course_rating_status'] ) ) {
                $query->where( 'course_ratings.course_rating_status', '=', $filters['course_rating_status']);
            }

            // Course is Featured
            if ( !empty( $filters['is_featured'] ) ) {
                $query->where( 'course.course_featured', '=', $filters['is_featured']);
            }

            // Course Rating Status
            if ( !empty( $filters['course_title'] ) ) {
                $query->where( 'course.course_title', 'like', "%{$filters['course_title']}%");
            }

            // Course Rating Feedback
            if ( !empty( $filters['course_feedback'] ) ) {
                $query->where( 'course_ratings.course_rating_feedback', 'like', "%{$filters['course_feedback']}%");
            }
            // Course Rating Course
            if ( !empty( $filters['course_id'] ) ) {
                $query->where( 'course_ratings.course_id', '=', $filters['course_id']);
            }
            // Course Rating Company
            if ( !empty( $filters['company_id'] ) ) {
                $query->where( 'course_ratings.company_id', '=', $filters['company_id']);
            }
            // Course Rating User
            if ( !empty( $filters['user_id'] ) ) {
                $query->where( 'course_ratings.user_id', '=', $filters['user_id']);
            }
            // Course Rating ID Sorting
            if ( !empty( $filters['course_rating_comment_sort_by_id'] ) ) {
                $query->orderBy( 'course_ratings.id', $filters['course_rating_comment_sort_by_id']);
            }

        }
        $query->whereNull('course.deleted_at');
        $query->select(
            'users.name', 'users.email', 'users.mobile_number', 'user_details.first_name', 'user_details.last_name',
            \DB::raw('IFNULL(IF(user_details.user_detail_photo REGEXP "https?", user_details.user_detail_photo, CONCAT("'.url('/').'",user_details.user_detail_photo)), CONCAT("'.url('/').'","/assets/img/user-default.png")) AS user_detail_photo'),
            'course.course_title','course.course_featured', 'companies.company_name', 'course_ratings.*',
            \DB::raw('CONVERT_TZ(course_ratings.created_at, "+00:00", "+06:00") AS created_at')
        );
        return $query;
    }
}
