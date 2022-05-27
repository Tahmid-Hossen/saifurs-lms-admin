<?php


namespace App\Repositories\Backend\Result;


use App\Models\Backend\Result\Result;
use App\Repositories\Repository;

class ResultRepository extends Repository
{

    /**
     * Specify Model Learn name
     *
     * @return mixed
     */
    public function model()
    {
        return Result::class;
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
    public function result($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'results.company_id');
        $query->leftJoin('quizzes', 'quizzes.id', '=', 'results.quiz_id');
        $query->leftJoin('course_batches', 'course_batches.id', '=', 'results.batch_id');
        $query->leftJoin('course', 'course.id', '=', 'results.course_id');
        $query->leftJoin('course_classes', 'course_classes.id', '=', 'results.class_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('results.result_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('results.result_details', 'like', "%{$filters['search_text']}%");
             $query->orWhere('results.total_score', 'like', "%{$filters['search_text']}%");
             $query->orWhere('results.pass_score', 'like', "%{$filters['search_text']}%");
             $query->orWhere('results.fail_score', 'like', "%{$filters['search_text']}%");
             $query->orWhere('results.result_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('quizzes.quiz_topic', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_batches.course_batch_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('results.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('results.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['quiz_id']) && $filters['quiz_id']) {
            $query->where('results.quiz_id', '=', $filters['quiz_id']);
        }

        if (isset($filters['batch_id']) && $filters['batch_id']) {
            $query->where('results.batch_id', '=', $filters['batch_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('results.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('results.class_id', '=', $filters['class_id']);
        }

        if (isset($filters['instructor_id']) && $filters['instructor_id']) {
            $query->where('course_batches.instructor_id', '=', $filters['instructor_id']);
        }

        if (isset($filters['result_title']) && $filters['result_title']) {
            $query->where('results.result_title', '=', $filters['result_title']);
        }

        if (isset($filters['result_details']) && $filters['result_details']) {
            $query->where('results.result_details', '=', $filters['result_details']);
        }

        if (isset($filters['total_score']) && $filters['total_score']) {
            $query->where('results.total_score', '=', $filters['total_score']);
        }

        if (isset($filters['pass_score']) && $filters['pass_score']) {
            $query->where('results.pass_score', '=', $filters['pass_score']);
        }

        if (isset($filters['fail_score']) && $filters['fail_score']) {
            $query->where('results.fail_score', '=', $filters['fail_score']);
        }

        if (isset($filters['result_status']) && $filters['result_status']) {
            $query->where('results.result_status', '=', $filters['result_status']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('results.created_at', array($filters['created_at'], $filters['created_at']));
        }

         $query
            ->orderBy('results.id', 'desc')
            ->select([
                'companies.*', 'results.*'
            ]);


        return $query;
    }

}
