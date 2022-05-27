<?php

namespace App\Services\Backend\Quiz;

use App\Repositories\Backend\Quiz\QuizRepository;
use Exception;

class QuizService {
    /**
     * @var QuizRepository
     */
    private $quizRepository;

    /**
     * UserDetailsService constructor.
     * @param QuizRepository $QuizRepository
     */
    public function __construct( QuizRepository $quizRepository ) {
        $this->quizRepository = $quizRepository;
    }

    public function returnArray( $object, $id, $columName ) {
        $arr = [];
        foreach ( $object as $obj ) {
            $arr[$obj->$id] = $obj->$columName;
        }
        return $arr;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createQuiz( $input ) {
        try {
            return $this->quizRepository->create( $input );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateQuiz( $input, $id ) {
        try {
            $userDetails = $this->quizRepository->find( $id );
            $this->quizRepository->update( $input, $id );
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
    public function showAllQuiz( $input ) {
        return $this->quizRepository->filterData( $input );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showQuizByID($id)
    {
        return $this->quizRepository->find($id);
    }

    /**
     * @param $input
     * @return false|mixed
     */
    public function quiz_custom_insert( $input ) {
        $quiz['company_id'] = $input['company_id'];
        $quiz['course_id'] = $input['course_id'];
        $quiz['course_category_id'] = isset($input['course_category_id']) ? $input['course_category_id'] : null;
        $quiz['course_sub_category_id'] = isset($input['course_sub_category_id']) ? $input['course_sub_category_id'] : null;
        // $quiz['drip_content'] = $quiz['visible_days'] = $quiz['visible_date'] = null;
        // if($input['visible_days'] == null && $input['visible_date'] == null){}
        // else{
        //     $quiz['drip_content'] = $input['drip_content_type'] ;
        //     if ( $input['drip_content_type'] == 'specific_date'  ) {
        //         $quiz['visible_date'] = isset($input['visible_date']) ? $input['visible_date'] : null;
        //         $quiz['visible_days'] = null;
        //     } else {
        //         $quiz['visible_days'] = isset($input['visible_days']) ? $input['visible_days'] : 0;
        //         $quiz['visible_date'] = null;
        //     }
        // }
        $quiz['quiz_type'] = $input['quiz_type'];
        $quiz['quiz_full_marks'] = $input['quiz_full_marks'];
        $quiz['quiz_topic'] = $input['quiz_topic'];
        $quiz['quiz_pass_percentage'] = $input['quiz_pass_percentage'];
        $quiz['quiz_url'] = $input['quiz_url'];
        $quiz['quiz_description'] = htmlentities( $input['quiz_description'] );
        $quiz['quiz_re_attempt'] = isset($input['quiz_re_attempt']) ? $input['quiz_re_attempt'] : 'NO';
        $quiz['quiz_status'] = isset($input['quiz_status']) ? $input['quiz_status'] : 'IN-ACTIVE';
        if(isset($input['quiz_duration'])):
            $duration = explode('-', $input['quiz_duration']);
            $quiz['quiz_start'] = $duration[0];
            $quiz['quiz_end'] = $duration[1];
            $quiz['quiz_duration'] = isset($input['quiz_duration']) ? $input['quiz_duration'] : null;
        endif;
        return $this->createQuiz( $quiz );
    }

    /**
     * @param $inputUpdate
     * @param $id
     * @return bool|mixed
     */
    public function quiz_custom_update( $input, $id ) {
        $quiz['company_id'] = $input['company_id'];
        $quiz['course_id'] = $input['course_id'];
        $quiz['course_category_id'] = isset($input['course_category_id']) ? $input['course_category_id'] : null;
        $quiz['course_sub_category_id'] = isset($input['course_sub_category_id']) ? $input['course_sub_category_id'] : null;
        $quiz['drip_content'] = $quiz['visible_days'] = $quiz['visible_date'] = null;
        // if($input['visible_days'] == null && $input['visible_date'] == null){}
        // else{
        //     $quiz['drip_content'] = $input['drip_content_type'] ;
        //     if ( $input['drip_content_type'] == 'specific_date'  ) {
        //         $quiz['visible_date'] = isset($input['visible_date']) ? $input['visible_date'] : null;
        //         $quiz['visible_days'] = null;
        //     } else {
        //         $quiz['visible_days'] = isset($input['visible_days']) ? $input['visible_days'] : 0;
        //         $quiz['visible_date'] = null;
        //     }
        // }
        $quiz['quiz_type'] = $input['quiz_type'];
        $quiz['quiz_full_marks'] = $input['quiz_full_marks'];
        $quiz['quiz_topic'] = $input['quiz_topic'];
        $quiz['quiz_pass_percentage'] = $input['quiz_pass_percentage'];
        $quiz['quiz_url'] = $input['quiz_url'];
        $quiz['quiz_description'] = htmlentities( $input['quiz_description'] );
        $quiz['quiz_re_attempt'] = isset($input['quiz_re_attempt']) ? $input['quiz_re_attempt'] : 'NO';
        $quiz['quiz_status'] = isset($input['quiz_status']) ? $input['quiz_status'] : 'IN-ACTIVE';
        if(isset($input['quiz_duration'])):
            $duration = explode('-', $input['quiz_duration']);
            $quiz['quiz_start'] = $duration[0];
            $quiz['quiz_end'] = $duration[1];
            $quiz['quiz_duration'] = isset($input['quiz_duration']) ? $input['quiz_duration'] : null;
        endif;
        return $this->updateQuiz( $quiz, $id );
    }
}
