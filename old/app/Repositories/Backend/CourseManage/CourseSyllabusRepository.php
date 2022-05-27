<?php


namespace App\Repositories\Backend\CourseManage;


use App\Models\Backend\Course\CourseSyllabus;
use App\Repositories\Repository;

class CourseSyllabusRepository extends Repository
{

    /**
     * Specify Model Syllabus name
     *
     * @return mixed
     */
    public function model()
    {
        return CourseSyllabus::class;
    }

    /**
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function courseSyllabus($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->leftJoin('companies', 'companies.id', '=', 'course_syllabuses.company_id');
        $query->leftJoin('course', 'course.id', '=', 'course_syllabuses.course_id');
        $query->leftJoin('course_classes', 'course_classes.id', '=', 'course_syllabuses.class_id');

         if (isset($filters['search_text']) && $filters['search_text']) {
             $query->where('course_syllabuses.syllabus_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_syllabuses.syllabus_slug', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_syllabuses.syllabus_details', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_syllabuses.syllabus_status', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_syllabuses.syllabus_featured', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_syllabuses.syllabus_seo_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_syllabuses.syllabus_position', 'like', "%{$filters['search_text']}%");
             $query->orWhere('companies.company_name', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course.course_title', 'like', "%{$filters['search_text']}%");
             $query->orWhere('course_classes.class_name', 'like', "%{$filters['search_text']}%");
         }

        if (isset($filters['id']) && $filters['id']) {
            $query->where('course_syllabuses.id', '=', $filters['id']);
        }

        if (isset($filters['company_id']) && $filters['company_id']) {
            $query->where('course_syllabuses.company_id', '=', $filters['company_id']);
        }

        if (isset($filters['course_id']) && $filters['course_id']) {
            $query->where('course_syllabuses.course_id', '=', $filters['course_id']);
        }

        if (isset($filters['class_id']) && $filters['class_id']) {
            $query->where('course_syllabuses.class_id', '=', $filters['class_id']);
        }

        if (isset($filters['syllabus_title']) && $filters['syllabus_title']) {
            $query->where('course_syllabuses.syllabus_title', '=', $filters['syllabus_title']);
        }

        if (isset($filters['syllabus_slug']) && $filters['syllabus_slug']) {
            $query->where('course_syllabuses.syllabus_slug', '=', $filters['syllabus_slug']);
        }

        if (isset($filters['syllabus_status']) && $filters['syllabus_status']) {
            $query->where('course_syllabuses.syllabus_status', '=', $filters['syllabus_status']);
        }

        if (isset($filters['syllabus_featured']) && $filters['syllabus_featured']) {
            $query->where('course_syllabuses.syllabus_featured', '=', $filters['syllabus_featured']);
        }

        if (isset($filters['course_syllabus_by_id']) && $filters['course_syllabus_by_id']) {
            $query->orderBy('course_syllabuses.id', $filters['course_syllabus_by_id']);
        }

        if (isset($filters['created_at']) && $filters['created_at']) {
            $query->whereBetween('course_syllabuses.created_at', array($filters['created_at'], $filters['created_at']));
        }

        $query->whereNull('course.deleted_at');
        $query->select([
            'companies.company_name',
            \DB::raw('IFNULL(IF(companies.company_logo REGEXP "https?", companies.company_logo, CONCAT("'.url('/').'",companies.company_logo)), CONCAT("'.url('/').'","/assets/img/default.png")) AS company_logo'),
            'course_syllabuses.*',
            \DB::raw('IFNULL(IF(course_syllabuses.syllabus_file REGEXP "https?", course_syllabuses.syllabus_file, CONCAT("'.url('/').'",course_syllabuses.syllabus_file)), CONCAT("'.url('/').'","/assets/img/default.png")) AS syllabus_files'),
            \DB::raw('CONVERT_TZ(course_syllabuses.created_at, "+00:00", "+06:00") AS created_at')
        ]);

        return $query;

    }

}
