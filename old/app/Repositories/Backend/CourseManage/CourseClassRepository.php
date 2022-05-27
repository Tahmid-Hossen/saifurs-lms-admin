<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseClass;
use App\Repositories\Repository;

class CourseClassRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseClass::class;
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
    public function courseClass($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_classes.company_id');
        $query->leftJoin('course', 'course.id', '=', 'course_classes.course_id');
        $query->leftJoin('course_category', 'course_category.id', '=', 'course.course_category_id');
        $query->leftJoin('course_sub_category', 'course_sub_category.id', '=', 'course.course_sub_category_id');
        $query->leftJoin('course_child_category', 'course_child_category.id', '=', 'course.course_child_category_id');
        $query->leftJoin('branches', 'branches.id', '=', 'course_classes.branch_id');
        $query->leftJoin('course_chapters', 'course_chapters.id', '=', 'course_classes.chapter_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_classes.class_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_type', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('branches.branch_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_category.course_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_sub_category.course_sub_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_child_category.course_child_category_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_chapters.chapter_title', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_classes.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_classes.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['branch_id']) && $filters['branch_id']) {
            $query->where('course_classes.branch_id', '=', $filters['branch_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_classes.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['chapter_id']) && $filters['chapter_id']) {
            $query->where('course_classes.chapter_id', '=', $filters['chapter_id']);
        }

        if (isset($filters['class_name']) && $filters['class_name']) {
            $query->where('course_classes.class_name', '=', $filters['class_name']);
        }

        if (isset($filters['class_slug']) && $filters['class_slug']) {
            $query->where('course_classes.class_slug', '=', $filters['class_slug']);
        }

        if (isset($filters['class_type']) && $filters['class_type']) {
            $query->where('course_classes.class_type', '=', $filters['class_type']);
        }

        if (isset($filters['class_status']) && $filters['class_status']) {
            $query->where('course_classes.class_status', '=', $filters['class_status']);
        }

        if (isset($filters['class_featured']) && $filters['class_featured']) {
            $query->where('course_classes.class_featured', '=', $filters['class_featured']);
        }

        if (isset($filters['class_sorting']) && $filters['class_sorting']) {
            $query->orderBy('course_classes.id', $filters['class_sorting']);
        }


        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_classes.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course.deleted_at');

         $query->select([
             'companies.company_name',
             \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
             'course_classes.*',
             \DB::raw('IFNULL(IF(course_classes.class_file REGEXP "https?", course_classes.class_file, CONCAT("'.url('/').'",course_classes.class_file)), CONCAT("'.url('/').'","/assets/img/default.png")) AS class_files'),
             \DB::raw('IFNULL(IF(course_classes.class_video REGEXP "https?", course_classes.class_video, CONCAT("'.url('/').'",course_classes.class_video)), CONCAT("'.url('/').'","/assets/img/default.png")) AS class_videos'),
             \DB::raw('CONVERT_TZ(course_classes.created_at, "+00:00", "+06:00") AS created_at')
            ]);


        return $query;
    }

    public function update(array $data, $id) : CourseClass
    {
        $course_class = $this->model->find($id);
        $course_class->fill($data);
        $course_class->save();
        return $course_class;
    }

}
