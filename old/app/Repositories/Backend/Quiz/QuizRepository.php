<?php

namespace App\Repositories\Backend\Quiz;

use App\Models\Backend\Quiz\Quiz;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class QuizRepository extends Repository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model() {
        return Quiz::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function filterData( $filters ): Builder {
        $query = $this->model->sortable()->newQuery();

        $query->join( 'companies', 'quizzes.company_id', '=', 'companies.id' );
        // $query->join( 'branches', 'quizzes.branch_id', '=', 'branches.id' ); // will need it in future
        $query->join( 'course', 'quizzes.course_id', '=', 'course.id' );

        if ( !empty( $filters ) ) {
            // Quiz ID
            if ( !empty( $filters['quiz_id'] ) ) {
                $query->where( 'quizzes.id', '=', $filters['quiz_id'] );
            }
            // Quiz Full Marks
            if ( !empty( $filters['quiz_full_marks'] ) ) {
                $query->where( 'quizzes.quiz_full_marks', '=', $filters['quiz_full_marks'] );
            }
            // Quiz Topic
            if ( !empty( $filters['quiz_topic'] ) ) {
                $query->where( 'quizzes.quiz_topic', 'like', "%{$filters['quiz_topic']}%" );
            }
            // Quiz Question URL
            if ( !empty( $filters['quiz_url'] ) ) {
                $query->where( 'quizzes.quiz_url', '=', $filters['quiz_url'] );
            }
            // Quiz Type
            if ( !empty( $filters['quiz_type'] ) ) {
                $query->where( 'quizzes.quiz_type', '=', $filters['quiz_type'] );
            }
            // Course ID that related to this Quiz
            if ( !empty( $filters['course_id'] ) ) {
                $query->where( 'quizzes.course_id', '=', $filters['course_id'] );
            }
            // Quiz Status
            if ( !empty( $filters['quiz_status'] ) ) {
                $query->where( 'quizzes.quiz_status', '=', $filters['quiz_status'] );
            }

            if ( !empty( $filters['quiz_start'] ) ) {
                $query->where( 'quizzes.quiz_start', '=', $filters['quiz_start'] );
            }

            if ( !empty( $filters['quiz_end'] ) ) {
                $query->where( 'quizzes.quiz_end', '=', $filters['quiz_end'] );
            }

            if ( !empty( $filters['quiz_duration'] ) ) {
                $query->where( 'quizzes.quiz_duration', '=', $filters['quiz_duration'] );
            }
        }
        $query->select( 'course.course_title', 'companies.company_name', 'quizzes.*' )
            ->orderBy( 'quizzes.id', 'desc' );
        return $query;
    }
}
