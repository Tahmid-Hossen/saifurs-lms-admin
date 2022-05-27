<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseQuestion;
use App\Repositories\Repository;

class CourseQuestionRepository extends Repository
{

    /**
     * Specify Model Question name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseQuestion::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param       $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function courseQuestion($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_questions.company_id');
        $query->leftJoin('quizzes', 'quizzes.id', '=', 'course_questions.quiz_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_questions.question', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_questions.question_position', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
			 $query->orWhere('quizzes.quiz_topic', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_questions.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_questions.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['quiz_id']) && $filters['quiz_id']) {
            $query->where('course_questions.quiz_id', '=', $filters['quiz_id']);
        }       

        if (isset($filters['question_name']) && $filters['question_name']) {
            $query->where('course_questions.question_name', '=', $filters['question_name']);
        }

        if (isset($filters['question_slug']) && $filters['question_slug']) {
            $query->where('course_questions.question_slug', '=', $filters['question_slug']);
        }

        if (isset($filters['question_status']) && $filters['question_status']) {
            $query->where('course_questions.question_status', '=', $filters['question_status']);
        }

        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_questions.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('quizzes.deleted_at');

         $query
            ->orderBy('course_questions.id', 'desc')
            ->select([
                'quizzes.quiz_topic','companies.*', 'course_questions.*',
                \DB::raw('CONVERT_TZ(course_questions.created_at, "+00:00", "+06:00") AS created_at')
            ]);


        return $query;
    }

    public function update(array $data, $id) : CourseQuestion
    {
        $course_question = $this->model->find($id);
        $course_question->fill($data);
        $course_question->save();
        return $course_question;
    }

}
