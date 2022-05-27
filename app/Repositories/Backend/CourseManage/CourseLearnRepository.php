<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseLearn;
use App\Repositories\Repository;

class CourseLearnRepository extends Repository
{

    /**
     * Specify Model Learn name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseLearn::class;
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
    public function courseLearn($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_learns.company_id');
        $query->leftJoin('course', 'course.id', '=', 'course_learns.course_id');
        $query->leftJoin('course_classes', 'course_classes.id', '=', 'course_learns.class_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_learns.learn_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_learns.learn_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_learns.learn_details', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_learns.learn_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_learns.learn_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_learns.learn_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_learns.learn_position', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_learns.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_learns.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_learns.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('course_learns.class_id', '=', $filters['class_id']);
        }

        if (isset($filters['learn_title']) && $filters['learn_title']) {
            $query->where('course_learns.learn_title', '=', $filters['learn_title']);
        }

        if (isset($filters['learn_slug']) && $filters['learn_slug']) {
            $query->where('course_learns.learn_slug', '=', $filters['learn_slug']);
        }

        if (isset($filters['learn_status']) && $filters['learn_status']) {
            $query->where('course_learns.learn_status', '=', $filters['learn_status']);
        }

        if (isset($filters['learn_featured']) && $filters['learn_featured']) {
            $query->where('course_learns.learn_featured', '=', $filters['learn_featured']);
        }

        if (isset($filters['course_learn_by_id']) && $filters['course_learn_by_id']) {
            $query->orderBy('course_learns.id', $filters['course_learn_by_id']);
        }

        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_learns.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course.deleted_at');

         $query->select([
             'companies.company_name',
             \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
             'course_learns.*',
             \DB::raw('IFNULL(IF(course_learns.learn_file REGEXP "https?", course_learns.learn_file, CONCAT("'.url('/').'",course_learns.learn_file)), CONCAT("'.url('/').'","/assets/img/default.png")) AS learn_files'),
             \DB::raw('CONVERT_TZ(course_learns.created_at, "+00:00", "+06:00") AS created_at')
            ]);


        return $query;
    }

}
