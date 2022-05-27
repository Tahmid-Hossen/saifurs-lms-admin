<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\QuestionAnswer;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class CourseQuestionAnswerRepository extends Repository
{

    /**
     * Specify Model Question name
     *
     * @return mixed
     */
    public function model()
    {
        return QuestionAnswer::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function courseQuestionAnswer($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('course_questions', 'course_questions.id', '=', 'course_question_answers.question_id');

        if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_question_answers.answer', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_question_answers.answer_slug', 'like', "%{$filters['search_text']}%");
/*             $query->orWhere('course_question_answers.answer_status', 'like', "%{$filters['search_text']}%");*/
             $query->orWhere('course_question_answers.answer_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_question_answers.answer_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_question_answers.answer_position', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question', 'like', "%{$filters['search_text']}%");
        }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_question_answers.id', '=', $filters['id']);
        }

        if (isset($filters['question_id']) && $filters['question_id']) {
            $query->where('course_question_answers.question_id', '=', $filters['question_id']);
        }

        if (isset($filters['answer']) && $filters['answer']) {
            $query->where('course_question_answers.answer', '=', $filters['answer']);
        }

        if (isset($filters['answer_slug']) && $filters['answer_slug']) {
            $query->where('course_question_answers.answer_slug', '=', $filters['answer_slug']);
        }

/*        if (isset($filters['answer_status']) && $filters['answer_status']) {
            $query->where('course_question_answers.answer_status', '=', $filters['answer_status']);
        }*/

        if (isset($filters['answer_featured']) && $filters['answer_featured']) {
            $query->where('course_question_answers.answer_featured', '=', $filters['answer_featured']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_question_answers.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course_questions.deleted_at');

         $query
            ->orderBy('course_question_answers.id', 'desc')
            // ->select([
            //     'companies.*', 'course_question_answers.*'
            // ]);
            ->select([
                'course_question_answers.*', \DB::raw('CONVERT_TZ(course_question_answers.created_at, "+00:00", "+06:00") AS created_at')
            ]);


        return $query;
    }

}
